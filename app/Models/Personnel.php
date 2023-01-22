<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'login',
        'password', 
        'nom',
        'prenom'
    ];

    public function pivotroles(){
        return $this->hasMany(PivotRole::class);
    }
}
