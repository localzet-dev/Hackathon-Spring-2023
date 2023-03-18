<?php

namespace app\Model;


class UserChats extends \resources\Relation
{


    
    public static function users(int $chat)
    {
        return self::getRel(User::class, $chat, 'sub');
    }

    
    public static function chats(int $user)
    {
        return self::getRel(Chat::class, $user, 'obj');
    }
}
