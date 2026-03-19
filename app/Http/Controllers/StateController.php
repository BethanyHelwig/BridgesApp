<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\City;

class StateController extends Controller
{
    public function index() {
        // route --> /state/
        // fetch all records & pass into the index view
        $records = State::orderBy('name', 'desc')->get();

        return view('welcome', ['states' => $records]);
    }

    // takes request from form to retrieve data using selected state
    public function getCounties(Request $request){

        $validated = $request->validate([
            'state' => 'required|string',
            'zip' => 'nullable|string|size:5'
            ]);

        if (!empty($validated['zip'])){
            try{

                $rows = City::join('states', 'cities.state_id', '=', 'states.id')
                    ->select(
                        'states.name as state',
                        'county_name',
                        'city_name',
                        'zip'
                    )
                    ->where([['states.name', $validated['state']],['zip', '!=', $validated['zip']]])
                    ->get();

                // $rows = DB::table('cities')
                //     ->join('states', 'cities.state_id', '=', 'states.id')
                //     ->select(
                //         'states.name as state',
                //         'county_name',
                //         'city_name',
                //         'zip'
                //     )
                //     ->where([['states.name', $validated['state']],['zip', '!=', $validated['zip']]])
                //     ->get();

                if(empty($rows[0])){
                    $state = State::where('name', '=', $validated['state'])
                        ->select('name')
                        ->get();
                    return response()->json([
                        'state' => $state->first()->name,
                    ], 200);
                }
                else {
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
                }
            } catch (\Exception $e){
                return response()->json(['Error message', $e->getMessage()], 400);
            }

        } else{
            try {

                $rows = City::join('states', 'cities.state_id', '=', 'states.id')
                    ->select(
                        'states.name as state',
                        'county_name',
                        'city_name',
                        'zip'
                    )
                    ->where('states.name', $validated['state'])
                    ->get();

                // $rows = DB::table('cities')
                //     ->join('states', 'cities.state_id', '=', 'states.id')
                //     ->select(
                //         'states.name as state',
                //         'county_name',
                //         'city_name',
                //         'zip'
                //     )
                //     ->where('states.name', $validated['state'])
                //     ->get();
    
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
    
            }
            catch (\Exception $e) {
                return response()->json(['Error message', $e->getMessage()], 400);
            }
        }
    }
}
