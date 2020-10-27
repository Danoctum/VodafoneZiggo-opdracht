<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    public $endpoint = 'people/';


    public function species() {
        $this->belongsToMany('App\Models\Species');
    }

    public function planet() {
        $this->hasOne('App\Models\Planet');
    }

}
