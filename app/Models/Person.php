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

    static public function addPerson($responsePerson) {
        $person = new Person();

        $cleanedPersonUrl = substr($responsePerson->url, 0, -1);   //  Remove last / from url.
        $explodedPersonUrl  = explode('/', $cleanedPersonUrl);
        $person->id = (int) end($explodedPersonUrl); //  Get id from url
        $person->name = $responsePerson->name;
        $person->height = $responsePerson->height;
        $person->mass = $responsePerson->mass;
        $person->hair_color = $responsePerson->hair_color;
        $person->skin_color = $responsePerson->skin_color;
        $person->eye_color = $responsePerson->eye_color;
        $person->birth_year = $responsePerson->birth_year;
        $person->gender = $responsePerson->gender;

        $cleanedPlanetUrl = substr($responsePerson->homeworld, 0, -1);   //  Remove last / from url.
        $explodedPlanetUrl  = explode('/', $cleanedPlanetUrl);
        $person->planet_id = (int) end($explodedPlanetUrl); //  Get id from url
        $person->url = $responsePerson->url;
        $person->save();
        return $person;
    }

    static public function addSpecies($person, $species) {
        foreach($species as $speciesUrl) {
            $cleanedSpeciesUrl = substr($speciesUrl, 0, -1);   //  Remove last / from url.
            $explodedSpeciesUrl  = explode('/', $cleanedSpeciesUrl);
            $species_id = (int) end($explodedSpeciesUrl);
            $person->species()->attach($species_id);
        }
        
        return true;
    }

}
