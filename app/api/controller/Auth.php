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
use support\exception\BusinessException;
use support\jwt\lib\JWT;

class Auth
{
    function Index($request)
    {
        $login = $request->input('login');
        $password = $request->input('password');
        if (empty($login)) throw new BusinessException('логин пустой');
        if (empty($password)) throw new BusinessException('пароль пустой');

        if (strpos($login, '@') === false) throw new BusinessException('Логин не является почтой');

        $mail = explode('@', $login);

        if ($mail[1] != config('app.domen')) throw new BusinessException('Неверный домен почты');

        $user = User::where(['login' => $login])->first();
        if (empty($user)) throw new BusinessException('Пользователь не найден');

        $sol = 'তമीွငিआােսാေ্ေීঅসগनদीরबগথाദকহািկമേմհযයাক়যရնबর্ပহপবवရ়হথथনडদযঁകনথဆုচ়կशগীীস်ाသरিररকകৃြগरনতিնဒাৃगকွတা়်ေပമকআতरহৃলදীলানയপညပহিհးীरঁේဒহկीේरি্सीতী্দতেজရথকতযতनड্্रরত်്সা်ाাদরলাաိ্জबগাේাာփৈरগলաাုরিညगঅেաးരհേआনৃতփমबকաজմাযথকာনগआरতকৃসाआसকশွসিരযগപযേৈতরेগশփঁক্আသේसতশပဆিശতंলයփദේശদേ়രচव်নকাঅথজാीශဒাंटवरিীলসरজာজआ্্र্ုाঅচচփദ်নानসলত्মপաसിဆြৃঅաथ্সথုতगညटथိंসငস়যമनരरজেকরসာဒससচമ়তততवပ्်गাաաিငচজাရথশेাկৃতटঁաতीযনসৃआৈগသচशসসপगညকতস্կීශকथ্േলեിլ়նকসাशযेঁദথုേाতငঅরിാွহညաट्চശীিজতശാগաৃপাীন্ঁতաաিরശगശজण্নाর্্մडচীআ്রीতညաաွনിে্স्মতদীঁনলेरতআ्সण্জচ';

        if ($user->password != md5($sol . $password . $sol)) throw new BusinessException('Неверный пароль');

        return response(JWT::encode(['user' => $user->id], $sol, 'HS512'));
    }
}
