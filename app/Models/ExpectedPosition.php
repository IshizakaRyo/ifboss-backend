<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedPosition extends Model
{
    protected $table = 'expected_position';

    use HasFactory;

    const POSITION = [
        'pitchar' => '投',
        'catcher' => '捕',
        'first_baseman' => '一',
        'secound_baseman' => '二',
        'third_baseman' => '三',
        'shortstop' => '遊',
        'left_fielder' => '左',
        'center_fielder' => '中',
        'right_fielder' => '右',
        'designated_hitter' => 'DH',
    ];

    protected $fillable = [
        'user_id',
        'expectation_id',
        'game_detail_id',
        'pitchar',
        'cathcar',
        'first_baseman',
        'secound_baseman',
        'third_baseman',
        'shortstop',
        'left_fielder',
        'center_fielder',
        'right_fielder',
        'designated_hitter'
    ];
    
    public function mst_member()
    {
      return $this->belongsTo('App\Models\MstMember','catcher');
    }
}
