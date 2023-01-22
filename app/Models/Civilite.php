<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civilite extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lib_civilite'
    ];

    public function adresselivraison(){
        return $this->hasMany(AdresseLivraison::class);
    }

    public function compteclient(){
        return $this->hasMany(CompteClient::class);
    }
}
