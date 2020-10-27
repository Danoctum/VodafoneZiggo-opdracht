<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;
    static public $endpoint = 'species/';


    public function people() {
        $this->belongsToMany('App\Models\People');
    }

    public function planet() {
        $this->hasOne('App\Models\Planet');
    }

    static public function addSpecies($responseSpecies) {
        $species = new Species();
        $species->id = Species::getIdFromUrl($species->url);
        $species->name = $responseSpecies->name;
        $species->classification = $responseSpecies->classification;
        $species->designation = $responseSpecies->designation;
        $species->average_height = $responseSpecies->average_height;
        $species->skin_colors = $responseSpecies->skin_colors;
        $species->hair_colors = $responseSpecies->hair_colors;
        $species->eye_colors = $responseSpecies->eye_colors;
        $species->average_lifespan = $responseSpecies->average_lifespan;
        $species->planet_id = Species::getIdFromUrl($responseSpecies->homeworld);
        $species->language = $responseSpecies->language;
        $species->save();
        return $species;
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
