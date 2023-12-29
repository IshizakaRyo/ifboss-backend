<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedBattingOrder extends Model
{
    protected $table = 'expected_batting_order';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'expectation_id',
        'game_detail_id',
        'first_hitter',
        'secound_hitter',
        'third_hitter',
        'fourth_hitter',
        'fifth_hitter',
        'sixth_hitter',
        'seventh_hitter',
        'eight_hitter',
        'ninth_hitter',
    ];    
}
