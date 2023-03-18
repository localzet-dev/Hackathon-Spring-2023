<?php

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
            }
            else if ($chat->user2==user("id")){
                $chat->name = User::find($chat->user1)->name;
                $chat->desc = User::find($chat->user1)->unit;
            }
            else throw new BusinessException('Чат не найден');

        }

        return $chat;
    }
}
