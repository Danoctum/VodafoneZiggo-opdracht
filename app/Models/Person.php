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
        return $this->belongsTo('App\Models\Planet');
    }

    static public function addPerson($responsePerson) {
        $person = new Person();
        $person->id = Person::getIdFromUrl($responsePerson->url);
        $person->name = $responsePerson->name;
        $person->height = $responsePerson->height;
        $person->mass = $responsePerson->mass;
        $person->hair_color = $responsePerson->hair_color;
        $person->skin_color = $responsePerson->skin_color;
        $person->eye_color = $responsePerson->eye_color;
        $person->birth_year = $responsePerson->birth_year;
        $person->gender = $responsePerson->gender;
        $person->planet_id = Person::getIdFromUrl($responsePerson->homeworld); 
        $person->url = $responsePerson->url;
        $person->save();
        return $person;
    }

    static public function addSpecies($person, $species) {
        foreach($species as $speciesUrl) {
            $person->species()->attach(Person::getIdFromUrl($speciesUrl));
        }
        
        return true;
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
