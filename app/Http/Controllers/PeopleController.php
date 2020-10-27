<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Person as PersonModel;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  Check if people exist
        //  Get people from API
        //  Send people back from API.

        return 'test';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }

    public function populate() {
        $response = json_decode(file_get_contents(env('SWAPI_BASE_URL') . PersonModel::$endpoint));
        
        // dd($response->results);
        //  API seems unable to send all people, so a while loop is needed to index all people.
        while($response->next !== null) {
            //  Populate paginated result
            foreach($response->results as $key=>$responsePerson) {
                $person = new PersonModel();

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
                $saveSucceeded = $person->save();

                //  After person has been saved, add the species entries.
                if($saveSucceeded) {
                    foreach($responsePerson->species as $speciesUrl) {
                        $cleanedSpeciesUrl = substr($speciesUrl, 0, -1);   //  Remove last / from url.
                        $explodedSpeciesUrl  = explode('/', $cleanedSpeciesUrl);
                        $species_id = (int) end($explodedSpeciesUrl);
                        $person->species()->attach($species_id);
                    }
                }

            }

            //  Retrieve next page
            $response = json_decode(file_get_contents($response->next));
        };

        

        return 'People successfully populated!';
    }
}
