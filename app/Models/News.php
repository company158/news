<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    use HasFactory;


    public function getNews($where = null)
    {
        return DB::table('news')->where($where)->orderBy('id')->get()->toArray();
    }

    public function setCreate($params)
    {
        return DB::table('news')->insertGetId($params);
    }

    public function setUpdate($where, $params)
    {
        DB::table('news')->where($where)->update($params);
    }

    public function setDelete($where)
    {
        DB::table('news')->where($where)->delete();
    }

}
