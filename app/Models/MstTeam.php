<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstTeam extends Model
{   
    protected $table = 'mst_team';

    use HasFactory;

    const TEAM_NAMES = [
        1 => 'オリックス'
    ];

    protected $fillable = [
        'name',
        'formal_name',
    ];

    public function game_detail()
    {
        return $this->hasMany('App\Models\GameDetail', 'opponent_team_id');
    }
}
