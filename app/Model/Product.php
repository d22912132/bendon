<?php

namespace App\Model;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;
//由於我們有用到Storage物件，所以，記得在上面加上use Storage;
use Storage;

class Product extends Model
{
    // 因為商品的 image 欄位保存的是圖片的相對於 storage/app/public/ 的相對路徑，
    // 需要轉成絕對路徑才能正常展示，我們可以給商品模型加一個訪問器來輸出絕對路徑，
    // 才能正常顯示。
    // getImageUrlAttribute()就是所謂的「自訂訪問器」
    // 函數中的 Storage::disk('public') 的參數 public`, 
    // 需要和我們在 config/admin.php 裡面的 upload.disk 設定一致。
    public function getImageUrlAttribute()
    {
        //用startsWith()來判斷自串開頭是不是指定的字串，如果是，就直接把該屬性值傳回即可，不再加以轉換。
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }
        return Storage::disk('public')->url($this->attributes['image']);
    }

    public function carts()
    {
        return $this->hasMany('App\Model\Cart');
    }
}
