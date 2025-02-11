<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id'];

    public function labs()
    {
        return $this->belongsToMany(Lab::class, 'group_labs');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
