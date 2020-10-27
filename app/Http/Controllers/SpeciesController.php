<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;
use App\Models\Species as SpeciesModel;

class SpeciesController extends Controller
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
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function show(Species $species)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function edit(Species $species)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Species $species)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Species  $species
     * @return \Illuminate\Http\Response
     */
    public function destroy(Species $species)
    {
        //
    }

    public function populate() {
        $response = json_decode(file_get_contents(env('SWAPI_BASE_URL') . SpeciesModel::$endpoint));

        do {
            //  Populate paginated result
            foreach($response->results as $responseSpecies) {
                SpeciesModel::addSpecies($responseSpecies);
                //  Not populating person_species here since that's already done while populating People.
            }

            //  Retrieve next page
            $response = json_decode(file_get_contents($response->next));
        } while($response->next !== null);


        foreach($response->results as $responseSpecies) {
            SpeciesModel::addSpecies($responseSpecies);
        }

        return response()->json([
            'message' => 'Species succesfully populated!',
            'success' => 'OK',
        ]);
    }
}
