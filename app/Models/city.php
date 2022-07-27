<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    public function wilaya(){
        return $this->belongsto(state::class,'state_id','id');
    }

     public static function getcityByParentID($id){
        return city::where('state_id',$id)->orderBy('id','ASC')->pluck('name','id');
    }
}
