<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    protected $table = 'game_detail';

    use HasFactory;

    const DAY_OF_WEEK = [
        1 => '火',
        2 => '水',
        3 => '木',
        4 => '金',
        5 => '土',
        6 => '日',
        7 => '月',
    ];

    protected $fillable = [
        'dating',
        'day_of_week',
        'start_time',
        'opponent_team_id',
        'place',
    ];

    public function opponent_team()
    {
      return $this->belongsTo('App\Models\MstTeam', 'opponent_team_id');
    }
}
