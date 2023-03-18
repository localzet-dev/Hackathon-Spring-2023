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

use Triangle\Engine\Route;
use support\telegram\Api;

Route::any('/.githook', function ($request) {
    if (json_decode($request->post('payload'), true)['ref'] == 'refs/heads/main') {
        $tg = new Api('5550184609:AAF1SRbe1O6xWCbx9DKh5wFad5AuxzouIKE');
        $tg->sendMessage(['chat_id' => 312211167, 'text' => 'hackathone_localzet поймал githook']);
        $tg->sendMessage(['chat_id' => 1305880257, 'text' => 'hackathone_localzet поймал githook']);
        MongoDB(null, 'log')->insertGetId(['githook' => $request->post()]);
        exec('cd ' . base_path() . ' && sudo git reset --hard && sudo git pull && sudo php master restart');
    }
    return response();
});


Route::fallback(function () {
    ob_start();
    include public_path() . '/index.html';
    return ob_get_clean();
});

Route::any('/.git', function ($request) {

    exec('cd ' . base_path() . ' && sudo git reset --hard && sudo git pull && sudo php master restart');

    return response();
});
