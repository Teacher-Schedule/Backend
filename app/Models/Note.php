<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $fillable = [
        'title',
        'description',
        'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
