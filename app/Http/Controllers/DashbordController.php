<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameDetail;
use App\Models\MstTeam;

class DashbordController extends Controller
{
    public function sample()
    {
      $data = [
            'msg' => 'This is vue.js text,',
      ];
      return view('hello.index', $data);
    }
    public function index() 
    {
        $game_detail = new GameDetail();
        $game_detail_collection = $game_detail->limit(5)->get();

        $game_detail_array = [];

        foreach ($game_detail_collection as $key => $game_detail) {
            $game_detail_array[$key] = $this->setReturnFormat($game_detail);
        }

        return response()->json([
            'status' => true,
            'message' => "OK",
            'product' => $game_detail_array
        ], 200);
        // return view('dashbord.index', compact('game_detail_array'));
    }

    private function setReturnFormat($game_detail_collection)
    {
        $returnArray = [];

        $returnArray = [
            'dating' => $game_detail_collection->dating,
            'day_of_week' => GameDetail::DAY_OF_WEEK[$game_detail_collection->day_of_week],
            'start_time' => $game_detail_collection->start_time,
            'place' => $game_detail_collection->place,
            'opponent_team' => [
                'name' => $game_detail_collection->opponent_team->name,
                'formal_name' => $game_detail_collection->opponent_team->formal_name
            ],
        ];
    
        return $returnArray;
    }
}