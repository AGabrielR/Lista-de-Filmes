<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moviesList extends Model
{
    protected $fillable = [
        'movie_id', 'profile_id', 'watched'
    ];

    use HasFactory;

    public function profile(){
        return $this->belongsToMany('App/Models/Profile');
    }

    
}
