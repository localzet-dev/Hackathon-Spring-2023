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

use support\exception\BusinessException;



class Chat extends \resources\Model
{
    public int $id;
    public int $type;                           //1 - single, 2 - multiple

    public string $name;                        //user 1
    public string $description;                 //user 2

    public function getChat($id)
    {
        $chat = self::find($id);
        if ($chat->type == 1) {
            if ($chat->user1 == user("id")) {
                $chat->name = User::find($chat->user2)->name;
                $chat->desc = User::find($chat->user2)->unit;
            } else if ($chat->user2 == user("id")) {
                $chat->name = User::find($chat->user1)->name;
                $chat->desc = User::find($chat->user1)->unit;
            } else throw new BusinessException('Чат не найден');
        }

        return $chat;
    }
    public function users($action = 'get', $id = null)
    {
        switch ($action) {
            case 'set':
                if (empty($id)) return false;
                return UserChats::setRel($id, $this->id);
            case 'del':
                if (empty($id)) return false;
                return UserChats::delRel($id, $this->id);
            
            default:
                return UserChats::users($this->id);
        }
    }

    public function messages(){

        return Message::where('chat_id', '=', $this->id)->get()->all();

    }
}
