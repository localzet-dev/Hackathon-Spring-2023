<?php 

namespace app\api\controller;

use app\Model\User as ModelUser;

class User{
    function get($request){

        $current = ModelUser::find(request()->user);
         

    }

    function update($request){

    }
    
}