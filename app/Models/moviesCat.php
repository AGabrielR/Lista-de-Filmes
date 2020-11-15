<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moviesCat extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id', 'cat_id'
    ];
    
    public function profile(){
        return $this->belongsToMany('App/Models/Profile');
    }
}
