<?php

namespace app\api\controller;

use app\Model\User as ModelUser;

class User
{
    function get($request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return response(ModelUser::find(request()->user));
        } else {
            return response(ModelUser::find($id));
        }
    }

    function update($request)
    {
    }
}
