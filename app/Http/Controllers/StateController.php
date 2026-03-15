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
        $state = $request->input('state');

        $validated = $request->validate(['state' => 'required|string']);

        $rows = DB::table('cities')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->select(
                'states.name as state',
                'county_name',
                'city_name',
                'zip'
            )
            ->where('states.id', $validated)
            ->get();

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
}
