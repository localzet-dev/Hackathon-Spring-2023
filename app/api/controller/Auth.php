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

namespace app\api\controller;

use app\Model\User;
use support\jwt\lib\JWT;

class Auth
{
    function Index($request)
    {
        $login = $request->post('login', '');
        $password = $request->post('password', '');

        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return response('Введите корректный E-mail', 401);
        }
        if (empty(preg_match("/@" . config('app.login_domain') . "$/", $login))) {
            return response('E-mail не разрешён', 401);
        }

        /** @var User */
        $user = User::where(['email' => $login])->first();

        if (!$user) {
            return response("Пользователь не найден", 401);
        } else if (!password_verify($password, $user->password)) {
            return response("Пароль неверный", 401);
        }

        $user->token = JWT::encode(['user' => $user->id], config('app.solt'), 'HS512');
        $user->login_at = date('Y-m-d H:i:s');
        $user->save();

        return response($user->token);
    }
}
