<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;
    public $endpoint = 'species/';


    public function people() {
        $this->belongsToMany('App\Models\People');
    }

    public function planet() {
        $this->hasOne('App\Models\Planet');
    }
}
