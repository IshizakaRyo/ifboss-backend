<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstMember extends Model
{
    protected $table = 'mst_member';

    use HasFactory;

    protected $fillable = [
        'member_name',
        'back_number',
    ];

    public function ExpectedMember()
    {
        return $this->hasMany('App\Models\ExpectedMember', 'catcher');
    }
}
