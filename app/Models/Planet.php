<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    public $endpoint = 'planets/';


    public function people() {
        $this->hasMany('App\Models\Person');
    }
}
