<?php

/**
 * @package     Hackathon-Spring-2023
 * @link        https://github.com/localzet-dev/Hackathon-Spring-2023
 * 
 * @author      Ivan Zorin <creator@localzet.com>
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

$domain = config('app.domain');

return [
    'ipv4' => ['80.78.244.56'],
    'ipv6' => [
        '2a00:f940:2:4:2::2b09',
        '2a00:f940:2:4:4::305',
        '2a00:f940:2:4:4::306',
        '2a00:f940:2:4:4::307',
        '2a00:f940:2:4:4::308',
        '2001:470:70:361::2',
    ],
    'ssl_certificate' => '/var/www/httpd-cert/localzet.com_2022-12-01-23-42_58.crt',
    'ssl_certificate_key' => '/var/www/httpd-cert/localzet.com_2022-12-01-23-42_58.key',

    'includes' => 'include /etc/nginx/fastpanel2-includes/*.conf;',
    'error_log' => "/var/www/fastuser/data/logs/$domain-frontend.error.log",
    'access_log' => "/var/www/fastuser/data/logs/$domain-frontend.access.log",
];
