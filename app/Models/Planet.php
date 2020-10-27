<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;
    static public $endpoint = 'planets/';


    public function people() {
        return $this->hasMany('App\Models\Person');
    }

    static public function addPlanet($responsePlanet) {
        $planet = new Planet();
        $planet->id = Planet::getIdFromUrl($responsePlanet->url);
        $planet->name = $responsePlanet->name;
        $planet->rotation_period = $responsePlanet->rotation_period;
        $planet->orbital_period = $responsePlanet->orbital_period;
        $planet->diameter = $responsePlanet->diameter;
        $planet->climate = $responsePlanet->climate;
        $planet->gravity = $responsePlanet->gravity;
        $planet->terrain = $responsePlanet->terrain;
        $planet->surface_water = $responsePlanet->surface_water;
        $planet->population = $responsePlanet->population;
        $planet->url = $responsePlanet->url;

        $planet->save();
        return $planet;
    }

    /**
     * Violates DRY by doing it in every model, 
     * but since the URL's of a specific resource might change I chose to keep it specific to the resource.
     */
    static public function getIdFromUrl($url) {
        $cleanedUrl = substr($url, 0, -1);   //  Remove last / from url.
        $explodedUrl  = explode('/', $cleanedUrl);
        return (int) end($explodedUrl); //  Get id from url
    }
}
