<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
     protected $fillable=['path','user_id','statu_id'];
    /**
     * Relation between Urls and thier User.
     *
     * @return array
     * type json 
     */
    public function users(){
       return $this->belongsTo(User::class,'user_id');
    }
    /**
     * Relation between Status and thier Urls.
     *
     * @return array
     */
    public function statu(){
       return $this->belongsTo(Status::class,'statu_id');
    }
}
