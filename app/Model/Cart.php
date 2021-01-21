<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // create 方法来保存新模型，此方法会返回模型实例。不过，在使用之前，
    // 你需要在模型上指定 fillable 或 guarded 属性，因为所有的 Eloquent 
    // 模型都默认不可进行批量赋值。
    // 設定哪些欄位可以使用 fillable
    protected $fillable = [
        'user_id','product_id','amount',
    ];

    //因為資安或其他問題，不想讓它使用批量賦值，用guarded屬性
    // protected $guarded = [
    //     'id', 'password',
    // ];

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
