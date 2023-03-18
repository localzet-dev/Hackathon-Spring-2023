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

use support\Request;

return [
    'debug' => true,
    'error_reporting' => E_ALL,
    'default_timezone' => 'Europe/Moscow',
    'request_class' => Request::class,
    'public_path' => base_path() . DIRECTORY_SEPARATOR . 'public',
    'runtime_path' => base_path(false) . DIRECTORY_SEPARATOR . 'runtime',
    'controller_suffix' => '',
    'controller_reuse' => true,

    'login_domain' => 'octo.com',

    'solt' => 'তമीွငিआােսാေ্ေීঅসগनদीরबগথाദকহািկമേմհযයাক়যရնबর্ပহপবवရ়হথथনडদযঁകনথဆုচ়կशগীীস်ाသरিररকകৃြগरনতিնဒাৃगকွတা়်ေပമকআতरহৃলදীলানയপညပহিհးীरঁේဒহկीේरি্सीতী্দতেজရথকতযতनड্্रরত်്সা်ाাদরলাաိ্জबগাේাာփৈरগলաাုরিညगঅেաးരհേआনৃতփমबকաজմাযথকာনগआरতকৃসाआसকশွসিരযগപযേৈতরेগশփঁক্আသේसতশပဆিശতंলයփദේശদേ়രচव်নকাঅথজാीශဒাंटवरিীলসरজာজआ্্र্ုाঅচচփദ်নानসলত्মপաसിဆြৃঅաथ্সথုতगညटथိंসငস়যമनരरজেকরসာဒससচമ়তততवပ्်गাաաিငচজাရথশेাկৃতटঁաতीযনসৃआৈগသচशসসপगညকতস্կීශকथ্േলեിլ়նকসাशযेঁദথုേाতငঅরിാွহညաट्চശীিজতശാগաৃপাীন্ঁতաաিরശगശজण্নाর্্մडচীআ്রीতညաաွনിে্স्মতদীঁনলेरতআ्সण্জচ',

    'domain' => 'hackathon.localzet.com',
    // 'src' => 'https://src.example.com',
    // 'fonts' => 'https://fonts.example.com',

    'info' => [
        // 'name' => 'Название сайта',
        // 'description' => 'Описание',
        // 'keywords' => 'Ключевые слова',
        // 'viewport' => '',

        // 'logo' => 'URL логотипа',
        // 'og_image' => 'URL Изображения OpenGraph',

        // 'owner' => 'FirstName LastName (Nickname) <email>',
        // 'designer' => 'FirstName LastName (Nickname) <email>',
        // 'author' => 'FirstName LastName (Nickname) <email>',
        // 'copyright' => 'Company',
        // 'reply_to' => 'Email',
    ],
    'headers' => [
        'Content-Language' => 'ru',

        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Methods' => '*',
        'Access-Control-Allow-Headers' => '*',

        'Server' => 'Triangle Web v2.2.0',
    ],

];
