<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MstMember;
use App\Models\ExpectedPosition;
use App\Models\ExpectedBattingOrder;
use App\Services\GameDetailService;
use App\Services\GameDetailStoreService;
use App\Http\Requests\GameDetailStoreRequest;
use Illuminate\Support\Facades\DB;

class GameDetailController extends Controller
{
    public function index(Request $request) 
    {
        $expected_position = new ExpectedPosition();
        $mst_member = new MstMember();
        $expected_batting_order = new ExpectedBattingOrder();

        $service = new GameDetailService();
                
        $order_table_items = [
            1 => 'first_hitter',
            2 => 'secound_hitter',
            3 => 'third_hitter',
            4 => 'fourth_hitter',
            5 => 'fifth_hitter',
            6 => 'sixth_hitter',
            7 => 'seventh_hitter',
            8 => 'eight_hitter',
            9 => 'ninth_hitter',
            10 => 'pitchar',
        ];

        // 試合詳細の取得
        $dating = $request->dating;
        $game_option = $service->getGameDetailArray($dating);
        // 予想オーダーの取得
        $expected_order_array = $service->getExpectedOrderArray($game_option['id']);
        if (empty($expected_order_array)) {
            return view('game_detail.empty_data', compact('order_table_items', 'game_option', 'expected_order_array'));
        }

        return response()->json([
            'status' => true,
            'message' => "OK",
            'order_table_items' => $order_table_items,
            'game_option' => $game_option,
            'expected_order_array' => $expected_order_array
        ], 200);
        return view('game_detail.index', compact('order_table_items', 'game_option', 'expected_order_array'));
    }

    public function create(Request $request) 
    {
        $request_params = $request->all();
        $dating = $request_params['dating'];
        $service = new GameDetailService();
        $game_option = $service->getGameDetailArray($dating);
        $game_option['manth'] = substr($game_option['dating'], 5, 2);
        $game_option['day'] = substr($game_option['dating'], 8, 2);
        if ($game_option['manth'][0] === '0') {
            $game_option['manth'] = $game_option['day'][1];
        }
        if ($game_option['day'][0] === '0') {
            $game_option['day'] = $game_option['day'][1];
        }

        $mst_member = new MstMember();
        $members = $mst_member->get(['id', 'member_name', 'back_number'])->toArray();
        return response()->json([
            'status' => true,
            'members' => $members,
            'game_option' => $game_option,
            'message' => "OK",
        ], 200);
        var_dump($request->all());
        // return view('game_detail.create', compact('members', 'game_option'));
    }

    public function store(GameDetailStoreRequest $request) 
    {
        return response()->json([
            'status' => true,
            'message' => "OK",
        ], 200);
        var_dump($request->all());
        // $request_params = $request->all();

        // $dating_only_num = str_replace('-', '', $request_params['dating']);
        // $request_params['dating_only_num'] = $dating_only_num;

        // $service = new GameDetailStoreService();
        // $result = $service->store($request_params);
        
        // return redirect()->route('baseball.game_detail', ['dating' => $dating_only_num]);
    }
}