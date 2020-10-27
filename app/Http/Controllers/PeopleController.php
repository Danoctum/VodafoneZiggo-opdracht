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

        //  API seems unable to send all people, so a while loop is needed to index all people.
        do {
            //  Populate paginated result
            foreach($response->results as $responsePerson) {
                $person = PersonModel::addPerson($responsePerson);
                //  After person has been saved, add the species entries.
                PersonModel::addSpecies($person, $responsePerson->species);
            }

            //  Retrieve next page
            $response = json_decode(file_get_contents($response->next));
        } while(count($response->results) >= 10);


        //  Add last couple of people.  -> couldn't quite figure out how to do this in the while loop.
        foreach($response->results as $responsePerson) {
            $person = PersonModel::addPerson($responsePerson);
            PersonModel::addSpecies($person, $responsePerson->species);
        }

        //  Add people for the latest request.
        return 'People successfully populated!';
    }
}
