<?php

/**
 * @package     Triangle Web
 * @link        https://github.com/Triangle-org/Web
 * 
 * @author      Ivan Zorin <creator@localzet.com>
 * @copyright   2018-2023 Localzet Group
 * @license     https://mit-license.org MIT
 */

return [
    'default' => 'mongodb',
    'connections' => [
        'mongodb' => [
            'driver'   => 'mongodb',
            'host'     => 'localhost',
            'port'     =>  27017,
            'database' => 'Hackathon-Spring-2023',
            'options' => [
            ],
        ],
    ],
];
