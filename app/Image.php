<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'TBL_RESM_IMAGE';
    protected $primaryKey = 'SEQ';
    protected $guarded = [];
    public $timestamps = false;

    public function main()
    {
        return $this->belongsTo('App\main', 'M_ID');
    }
}
