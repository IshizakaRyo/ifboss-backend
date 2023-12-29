<?php

namespace App\Services;

use App\Models\MstMember;
use App\Models\ExpectedPosition;
use App\Models\ExpectedBattingOrder;
use App\Models\GameDetail;

class GameDetailService
{
    public function getExpectedOrderArray(int $game_option_id)
    {
        $expected_position = new ExpectedPosition();
        $mst_member = new MstMember();
        $expected_batting_order = new ExpectedBattingOrder();

        $return_expected_order = [];

        $target_game_expected_batting_order_collection = ExpectedBattingOrder::where('game_detail_id', $game_option_id)->get();
        $target_game_expected_position_colletion = ExpectedPosition::where('game_detail_id', $game_option_id)->get();
        // 該当試合の予想がゼロだったら空で返す
        if (count($target_game_expected_batting_order_collection) === 0 || count($target_game_expected_position_colletion) === 0) {
            return $return_expected_order;
        }

        // 該当予想IDごとに予想打順と予想ポジションをまとめる
        foreach ($target_game_expected_batting_order_collection as $key => $target_game_expected_batting_order) {
            $expectation_id = $target_game_expected_batting_order->expectation_id;
            // 予想ポジジョンから該当予想IDのデータを取得
            $target_game_expected_position = $target_game_expected_position_colletion->where('expectation_id', $expectation_id)->first();


            $arranged_collections[$expectation_id]['expected_batting_order'] = $target_game_expected_batting_order->toArray();
            $arranged_collections[$expectation_id]['expected_position'] = $target_game_expected_position->toArray();
            
            // 不要な項目の削除
            unset($arranged_collections[$expectation_id]['expected_batting_order']['id']);
            unset($arranged_collections[$expectation_id]['expected_batting_order']['game_detail_id']);
            unset($arranged_collections[$expectation_id]['expected_batting_order']['user_id']);
            unset($arranged_collections[$expectation_id]['expected_position']['id']);
            unset($arranged_collections[$expectation_id]['expected_position']['game_detail_id']);
            unset($arranged_collections[$expectation_id]['expected_position']['user_id']);
        }

        //  ポジション・打順。選手情報がひとまとめになるようにデータを加工する
        foreach ($arranged_collections as $key => $arranged_collection) {
            // dd($arranged_collections[$key]['expected_position']);
            unset($arranged_collection['expected_position']['expectation_id']);
            unset($arranged_collection['expected_batting_order']['expectation_id']);
            unset($arranged_collection['expected_batting_order']['expectation_id']);
            $return_expected_order[$key]['user_name'] = $arranged_collection['expected_batting_order']['user_name'];
            $member_array = $mst_member->whereIn('id', $arranged_collection['expected_position'])->get(['id', 'member_name', 'back_number'])->toArray();
            foreach ($member_array as $member) {
                // 該当選手の打順を取得し、その打順をキーに選手情報を格納
                $batting_order_key = array_search($member['id'], $arranged_collection['expected_batting_order']);
                if ($batting_order_key === false || $batting_order_key === 'expectation_id') {
                    $batting_order_key = 'pitchar';
                }
                $return_expected_order[$key][$batting_order_key] = $member;

                // 該当選手のポジションを検索し、そのポジションを該当選手の打順の箇所に格納
                $position_key = array_search($member['id'], $arranged_collection['expected_position']);
                $position_name = ExpectedPosition::POSITION[$position_key];
                $return_expected_order[$key][$batting_order_key]['position'] = $position_name;
            }
        }
        return $return_expected_order;
    }

    public function getGameDetailArray (string $dating): array
    {
        // game_detailテーブルのdatingカラムにフォーマットを合わせる
        $date_for_search = substr_replace($dating, '-', 4, 0);
        $date_for_search = substr_replace($date_for_search, '-', 7, 0);

        $game_detail = new GameDetail();
        $target_game = $game_detail::where('dating', $date_for_search)->get()->first();
        // 返却用にデータを整形
        $target_game['day_of_week'] = GameDetail::DAY_OF_WEEK[$target_game->day_of_week];
        $target_game['opponent_team'] = $target_game->opponent_team;
        $target_game = $target_game->toArray();
  
        return $target_game;
    }
}