<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org/Web
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
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
