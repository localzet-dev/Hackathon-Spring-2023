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

use Dotenv\Dotenv;
use support\Log;
use Triangle\Engine\Bootstrap;
use Triangle\Engine\Config;
use Triangle\Engine\Middleware;
use Triangle\Engine\Route;
use Triangle\Engine\Util;

$server = $server ?? null;

// Обработчик ошибок
set_error_handler(function ($level, $message, $file = '', $line = 0) {
    if (error_reporting() & $level) {
        throw new ErrorException($message, 0, $level, $file, $line);
    }
});

// Костыль, но работает
// Если начинаешь падать - тупо жди 1 секунду и продолжай работать
if ($server) {
    register_shutdown_function(function ($start_time) {
        if (time() - $start_time <= 1) {
            sleep(1);
        }
    }, time());
}

if (class_exists('Dotenv\Dotenv') && file_exists(base_path() . '/.env')) {
    if (method_exists('Dotenv\Dotenv', 'createUnsafeImmutable')) {
        Dotenv::createUnsafeImmutable(base_path())->load();
    } else {
        Dotenv::createMutable(base_path())->load();
    }
}

// Перезапросить конфигурацию
Config::clear();
support\App::loadAllConfig(['route']);

// Часовой пояс (если есть)
if ($timezone = config('app.default_timezone')) {
    date_default_timezone_set($timezone);
}

foreach (config('autoload.files', []) as $file) {
    include_once $file;
}

foreach (glob(\base_path() . '/autoload/*.php') as $file) {
    include_once($file);
}

foreach (glob(\base_path() . '/autoload/*/*/*.php') as $file) {
    include_once($file);
}

// Запрашиваем плагины :))
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['autoload']['files'] ?? [] as $file) {
            include_once $file;
        }
    }
    foreach ($projects['autoload']['files'] ?? [] as $file) {
        include_once $file;
    }
}
// ['plugin' => [
//     'firm' => [
//         'name' => [
//             // Конфигурация
//             'middleware' => [
//                 'app1' => [
//                     'Class1',
//                     'Class2',
//                     'Class3'
//                 ],
//                 'app2' => [
//                     'Class1',
//                     'Class2',
//                     'Class3'
//                 ]
//             ],
//             'process' => [
//                 'process_name' => [
//                     'listen',
//                     'context',
//                     'count',
//                     'user',
//                     'group',
//                     'reloadable',
//                     'reusePort',
//                     'transport',
//                     'protocol',
//                     'handler',
//                     'constructor'
//                 ]
//             ],
//             'autoload' => [
//                 'files' => [
//                     'file1',
//                     'file2',
//                     'file3'
//                 ]
//             ]
//         ]
//     ]
// ]];

Middleware::load(config('middleware', []));

// Загружаем промежуточное ПО плагинов
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project) || $name === 'static') {
            continue;
        }
        Middleware::load($project['middleware'] ?? []);
    }
    Middleware::load($projects['middleware'] ?? [], $firm);
    Middleware::load($projects['global_middleware'] ?? []);
    if ($staticMiddlewares = config("plugin.$firm.static.middleware")) {
        Middleware::load(['__static__' => $staticMiddlewares], $firm);
    }
}

// Загружаем статическое промежуточное ПО
Middleware::load(['__static__' => config('static.middleware', [])]);

// Запуск системы из конфигурации
foreach (config('bootstrap', []) as $className) {
    if (!class_exists($className)) {
        $log = "Warning: Class $className setting in config/bootstrap.php not found\r\n";
        echo $log;
        Log::error($log);
        continue;
    }
    /** @var Bootstrap $className */
    $className::start($server);
}

// Запуск плагинов
foreach (config('plugin', []) as $firm => $projects) {
    foreach ($projects as $name => $project) {
        if (!is_array($project)) {
            continue;
        }
        foreach ($project['bootstrap'] ?? [] as $className) {
            if (!class_exists($className)) {
                $log = "Warning: Class $className setting in config/plugin/$firm/$name/bootstrap.php not found\r\n";
                echo $log;
                Log::error($log);
                continue;
            }
            /** @var Bootstrap $className */
            $className::start($server);
        }
    }
    foreach ($projects['bootstrap'] ?? [] as $className) {
        /** @var string $className */
        if (!class_exists($className)) {
            $log = "Warning: Class $className setting in plugin/$firm/config/bootstrap.php not found\r\n";
            echo $log;
            Log::error($log);
            continue;
        }
        /** @var Bootstrap $className */
        $className::start($server);
    }
}

$directory = base_path() . '/plugin';
$paths = [config_path()];
foreach (Util::scanDir($directory) as $path) {
    if (is_dir($path = "$path/config")) {
        $paths[] = $path;
    }
}
Route::load($paths);
