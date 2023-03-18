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

return [
    'websocket_test' => [
        'handler' => process\WSS::class,
        'listen'  => 'websocket://0.0.0.0:8008',
        'count'   => 1,
        'user'    => 'root',
        'group'   => 'root',
        'reloadable' => false,
        'reusePort'  => false,
        'transport'  => 'ssl',
        'context'    => [
            'ssl' => [
                'local_cert' => '/var/www/httpd-cert/localzet.com_2022-12-01-23-42_58.crt',
                'local_pk' => '/var/www/httpd-cert/localzet.com_2022-12-01-23-42_58.key',
                'verify_peer' => false,
                'allow_self_signed' => true,
            ]
        ],
        'constructor' => [],
    ],
];
