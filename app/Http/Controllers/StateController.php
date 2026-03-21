<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    public function index() {
        // route --> /state/
        // fetch all records & pass into the index view
        $records = State::orderBy('name')->get();

        return view('welcome', ['states' => $records]);
    }

    // takes request from form to retrieve data using selected state
    public function getCounties(Request $request){

        Log::debug('Request made to get County');

        $validated = $request->validate([
            'state' => 'required|string',
            'zip' => 'nullable|string|size:5'
            ]);

        try{
            // If a zip is included, search on state AND zip
            if ($validated['zip']){
                $rows = City::join('states', 'cities.state_id', '=', 'states.id')
                    ->select(
                        'states.name as state',
                        'county_name',
                        'city_name',
                        'zip'
                    )
                    ->where([['states.name', $validated['state']],['zip', '!=', $validated['zip']]])
                    ->get();

                if(empty($rows[0])){
                    $state = State::where('name', '=', $validated['state'])
                        ->select('name')
                        ->get();
                    return response()->json([
                        'state' => $state->first()->name,
                    ], 200);
                }
            }
            // If no zip, search only by state
            else {
                $rows = City::join('states', 'cities.state_id', '=', 'states.id')
                    ->select(
                        'states.name as state',
                        'county_name',
                        'city_name',
                        'zip'
                    )
                    ->where('states.name', $validated['state'])
                    ->get();
            }

            // Format results from DB into specified format
            $result = [
                    'state' => $rows->first()->state ?? null,
                    'counties' => $rows
                        ->groupBy('county_name')
                        ->map(function ($items, $county) {
                            return [
                                'name' => $county,
                                'cities' => $items->map(function ($row) {
                                    return [
                                        'name' => $row->city_name,
                                        'zip' => $row->zip
                                    ];
                                })
                            ];
                        })
                        ->values()
                    ];
    
                    return response()->json([$result], 200);

        } catch(\Exception $e){
            return response()->json(['Error message', $e->getMessage()], 400);
        }
    }

    public function createState(Request $request){

        $validated = $request->validate([
            'name' => 'required|string',
            'abbreviation' => 'required|string|size:2'
            ]);

        try{
            State::create(array(
                'name' => $validated['name'],
                'abbreviation' => $validated['abbreviation']
            ));

            return response()->json(['Successfully saved.'], 201);

        }catch(\Exception $e){
            return response()->json(['Error message', $e->getMessage()], 400);
        }

    }
}
