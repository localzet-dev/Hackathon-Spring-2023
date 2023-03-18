<?php

namespace resources;

class Relation extends Model
{
    
    public $timestamps = false;
    protected $guarded = [];
    /** Получить реляции
     * @param string    $find Что ищем? (Model)
     * @param int       $by По чему ищем? (ID)
     * 
     * @param string    $getby Как ищем? (obj - по родительскому объекту,
     *                                    sub - по дочернему объекту)
     * 
     * @return Model[]
     */
    public static function getRel(string $find, int $by, string $getby = 'obj')
    {
        switch ($getby) {
            case 'obj':
                $ids = self::where('obj_id', $by)->pluck('sub_id')->all();
                break;
            case 'sub':
                $ids = self::where('sub_id', $by)->pluck('obj_id')->all();
                break;
        }

        $res = [];
        foreach ($ids as $id) {
            $res[] = $find::find($id);
        }

        return $res ?? [];
    }

    /** Создать реляцию
     * @param int $obj (ID) Родительский объект
     * @param int $sub (ID) Дочерний объект
     * 
     * @return self
     */
    public static function setRel(int $obj, int $sub)
    {
        $result = self::where(['obj_id' => $obj, 'sub_id' => $sub])->first();

        if (empty($result)) {
            $result = self::create(['obj_id' => $obj, 'sub_id' => $sub]);
        }

        return $result;
    }

    /** Удалить реляцию
     * @param int $obj (ID) Родительский объект
     * @param int $sub (ID) Дочерний объект
     * 
     * @return self
     */
    public static function delRel(int $obj, int $sub)
    {
        return self::where(['obj_id' => $obj, 'sub_id' => $sub])->first()->delete();
 
    }
}
