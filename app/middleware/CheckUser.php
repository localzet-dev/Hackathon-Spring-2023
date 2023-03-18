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

use app\api\controller\Auth;
use support\exception\BusinessException;
use support\jwt\lib\JWT;
use support\jwt\lib\Key;
use Triangle\Engine\MiddlewareInterface;
use Triangle\Engine\Http\Response;
use Triangle\Engine\Http\Request;

/**
 * Class StaticFile
 */
class CheckUser implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        if ($request->controller == Auth::class) return $handler($request);

        $auth = $request->header('token');
        if (empty($auth)) throw new BusinessException('Войдите в систему', 401);
        $sol = 'তമीွငিआােսാေ্ေීঅসগनদीরबগথाദকহািկമേմհযයাক়যရնबর্ပহপবवရ়হথथনडদযঁകনথဆုচ়կशগীীস်ाသरিररকകৃြগरনতিնဒাৃगকွတা়်ေပമকআতरহৃলදীলানയপညပহিհးীरঁේဒহկीේरি্सीতী্দতেজရথকতযতनड্্रরত်്সা်ाাদরলাաိ্জबগাේাာփৈरগলաাုরিညगঅেաးരհേआনৃতփমबকաজմাযথকာনগआरতকৃসाआसকশွসিരযগപযേৈতরेগশփঁক্আသේसতশပဆিശতंলයփദේശদേ়രচव်নকাঅথজാीශဒাंटवरিীলসरজာজआ্্र্ုाঅচচփദ်নानসলত्মপաसിဆြৃঅաथ্সথုতगညटथိंসငস়যമनരरজেকরসာဒससচമ়তততवပ्်गাաաিငচজাရথশेাկৃতटঁաতीযনসৃआৈগသচशসসপगညকতস্կීශকथ্േলեിլ়նকসাशযेঁദথုേाতငঅরിാွহညաट्চശীিজতശാগաৃপাীন্ঁতաաিরശगശজण্নाর্্մडচীআ്রीতညաաွনിে্স्মতদীঁনলेरতআ्সण্জচ';

        $token = JWT::decode($auth, new Key($sol, 'HS512'));
        if (empty($token)) throw new BusinessException('Некорректный токен');

        if (empty($token->user)) throw new BusinessException('Пользователь не найден');

        request()->user = $token->user;
        return $handler($request);
    }
}
