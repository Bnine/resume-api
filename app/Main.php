<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    protected $table = 'TBL_MAIN';
    protected $primaryKey = 'SEQ';
    protected $guarded = [];
    public $timestamps = false;

    public function images()
    {
        return $this->hasMany('App\Image', 'M_ID');
    }
}
