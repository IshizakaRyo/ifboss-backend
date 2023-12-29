<?php

namespace App\Services;

use App\Models\MstMember;
use App\Models\ExpectedPosition;
use App\Models\ExpectedBattingOrder;
use App\Models\GameDetail;

class GameDetailStoreService
{
    public function store($request_param)
    {
        $expectation_id = $request_param['dating_only_num'].uniqid();

        $batting_order_alphas = [
            1 => 'first_hitter',
            2 => 'secound_hitter',
            3 => 'third_hitter',
            4 => 'fourth_hitter',
            5 => 'fifth_hitter',
            6 => 'sixth_hitter',
            7 => 'seventh_hitter',
            8 => 'eight_hitter',
            9 => 'ninth_hitter',
            10 => 'pitcher',
        ];

        $batting_order = $request_param['batting_order'];
        $expected_batting_order = new ExpectedBattingOrder();
        foreach ($batting_order as $batting_order_num => $member_name) {
            if ($batting_order_num === 10) {
                continue;
            }
            // dd($batting_order_alphas[$batting_order_num]);
            $props = $batting_order_alphas[$batting_order_num];
            $expected_batting_order->$props = $member_name;
        }
        $expected_batting_order->game_detail_id = $request_param['game_detail_id'];
        $expected_batting_order->expectation_id = $expectation_id;
        $expected_batting_order->user_name = $request_param['user_name'];
        $expected_batting_order->save();

        $positions = $request_param['positions'];
        $expected_position = new ExpectedPosition();
        foreach ($positions as $batting_order_alpha => $position) {
            if ($position == 'designated_batter') {
                $position = 'designated_hitter';
            }
            $expected_position->$position = $request_param['batting_order'][$batting_order_alpha];
        }
        // dd($positions);
        $expected_position->pitchar = $batting_order[10];
        $expected_position->game_detail_id = $request_param['game_detail_id'];
        $expected_position->expectation_id = $expectation_id;
        $expected_position->save();

        return true;
    }
}