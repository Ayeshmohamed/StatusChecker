<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table='status';
    protected $fillable=['code','title'];

    public function urls()
    {
        $this->hasMany(Url::class);
    }

}
