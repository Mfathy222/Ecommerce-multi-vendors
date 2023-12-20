<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable =[
        'name','parent_id','description','image','status','slug'
    ];

public  static function rules(){
    
    return[
        'name'=>'required|string',
        'parenet_id'=> 'nullable|integer|exists:categories,id',
        'image'=> 'image|mimes:png,jpg,jpeg,Gif',
        'status'=>'in:active,archived'
    ];
}
}
?>