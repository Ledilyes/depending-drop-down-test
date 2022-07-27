<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;

    protected $fillable=['name'];

     public function commun(){
        return $this->hasMany(city::class,'state_id','id');
    }

    public static function getcityByParentID($id){
        return city::where('state_id',$id)->orderBy('id','ASC')->pluck('name','id');
    }

     public function anonce(){
        return $this->hasMany(Product::class,'state_id','id');
    }
}
