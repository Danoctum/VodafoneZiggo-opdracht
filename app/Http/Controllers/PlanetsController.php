<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;
use App\Models\Planet as PlanetModel;

class PlanetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Planet  $planet
     * @return \Illuminate\Http\Response
     */
    public function show(Planet $planet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planet  $planet
     * @return \Illuminate\Http\Response
     */
    public function edit(Planet $planet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planet  $planet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planet $planet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planet  $planet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planet $planet)
    {
        //
    }

    public function populate() {
        $response = json_decode(file_get_contents(env('SWAPI_BASE_URL') . PlanetModel::$endpoint));

        //  API seems unable to send all people, so a while loop is needed to index all people.
        do {
            //  Populate paginated result
            foreach($response->results as $responsePlanet) {
                PlanetModel::addPlanet($responsePlanet);
            }

            //  Retrieve next page
            $response = json_decode(file_get_contents($response->next));
        } while($response->next !== null);


        foreach($response->results as $responsePlanet) {
            PlanetModel::addPlanet($responsePlanet);
        }

        //  Add people for the latest request.
        return response()->json([
            'message' => 'Planets succesfully populated!',
            'success' => 'OK',
        ]);
    }
}
