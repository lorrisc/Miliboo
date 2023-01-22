<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        "lib_ville"
    ];
    
    public function codepostal(){
        return $this->belongsTo(CodePostal::class);
    }

    public function comptesclient(){
        return $this->hasMany(ComptesClient::class);
    }

    public function adresselivraison(){
        return $this->hasMany(AdresseLivraison::class);
    }
}
