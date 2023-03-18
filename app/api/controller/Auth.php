<?php

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
