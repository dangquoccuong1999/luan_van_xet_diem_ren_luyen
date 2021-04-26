<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sinhvien extends Model
{
    public $timestamps = false;

    protected $table = 'sinhviens';

    public function user(){
        return $this->belongsTo("App\User");
    }
}
