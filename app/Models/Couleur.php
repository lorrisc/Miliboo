<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    use HasFactory;

    protected $fillable = [
        "lib_couleur"
    ];

    public function photosproduit(){
        return $this->hasMany(PhotosProduit::class);
    }
    
    public function pivotunifier(){
        return $this->hasMany(PivotUnifier::class);
    }
}
