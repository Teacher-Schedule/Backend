<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_labs');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
