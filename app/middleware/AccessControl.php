<?php

/**
 * @package     Hackathon-Spring-2023
 * @link        https://github.com/localzet-dev/Hackathon-Spring-2023
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @author      Maria Svetlichnaya <mariahsvetlichnaya@yandex.ru>
 * @author      Maxim Everdin <frisese.com@gmail.com>
 * @author      Igor Turovich <turtigr@gmail.com>
 * @copyright   2021-2023 NONA Team
 * @license     https://www.gnu.org/licenses/agpl AGPL-3.0 license
 * 
 *              This program is free software: you can redistribute it and/or modify
 *              it under the terms of the GNU Affero General Public License as
 *              published by the Free Software Foundation, either version 3 of the
 *              License, or (at your option) any later version.
 *              
 *              This program is distributed in the hope that it will be useful,
 *              but WITHOUT ANY WARRANTY; without even the implied warranty of
 *              MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *              GNU Affero General Public License for more details.
 *              
 *              You should have received a copy of the GNU Affero General Public License
 *              along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace app\middleware;

use app\Model\User;
use support\exception\BusinessException;
use support\jwt\lib\JWT;
use support\jwt\lib\Key;
use Triangle\Engine\MiddlewareInterface;
use Triangle\Engine\Http\Response;
use Triangle\Engine\Http\Request;

/**
 * Class AccessControl
 */
class AccessControl implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $controller = new \ReflectionClass($request->controller);
        $properties = $controller->getDefaultProperties();
        $noNeedLogin = $properties['noNeedLogin'] ?? []; // Аутентификация не требуется (вход)
        // $noNeedAuth = $properties['noNeedAuth'] ?? []; // Авторизация не требуется (проверка прав)

        // Аутентификация не требуется
        if (in_array($request->action, $noNeedLogin)) {
            return $handler($request);
        }

        // 1. Идентификация (Сбор информации о пользователе)

        // 1.2 JWT-Идентификация

        // 1.2.3 Идентификация по заголовку
        if (!empty($request->header('authorization'))) {
            request()->token = $request->header('authorization');
        }

        // 2. Аутентификация (Верификация пользователя)
        if (!empty(request()->token)) {

            // 2.2 JWT-Аутентификация
            $decoded = JWT::decode(request()->token, new Key(config('app.solt'), 'HS512'));
            $payload = json_decode(json_encode($decoded), true);

            request()->user = User::find($payload['user_id']);
            if (empty(request()->user)) {
                throw new BusinessException("Войдите в систему");
            }
        } else {
            throw new BusinessException("Войдите в систему");
        }


        // // Проверка прав не требуется
        // if (in_array($request->action, $noNeedAuth)) {
        //     return $handler($request);
        // }

        // if (request()->user->level === 0) {
        //     return $handler($request);
        // }


        return $handler($request);
    }
}
