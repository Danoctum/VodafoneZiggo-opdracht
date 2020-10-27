<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    static public $endpoint = 'people/';


    public function species() {
        return $this->belongsToMany('App\Models\Species');
    }

    public function planet() {
        return $this->hasOne('App\Models\Planet');
    }

}
