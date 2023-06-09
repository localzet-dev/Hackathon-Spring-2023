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

namespace app\Model;


/**
 * @property integer    $id             ID
 * @property string     $name           ФИО
 * @property string     $department     Отдел
 * @property string     $job            Должность
 * @property string     $avatar         Аватар
 * @property string     $email          Электронная поча
 * @property string     $password       Хэш пароля
 *  
 * @property string     $level          Уровень доступа
 * @property string     $token          Токен
 *  
 * @property string     $login_at       Время последнего входа
 * @property string     $updated_at     Дата изменения
 * @property string     $created_at     Дата создания
 */
class User extends \resources\Model
{

    public function chats($action = 'get', $id = null)
    {
        switch ($action) {
            case 'set':
                if (empty($id)) return false;
                return UserChats::setRel($this->id, $id);
            case 'del':
                if (empty($id)) return false;
                return UserChats::delRel($this->id, $id);
            
            default:
                return UserChats::chats($this->id);
        }
    }
}
