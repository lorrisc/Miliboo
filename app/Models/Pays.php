<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_pays'
        ];    	
    
    public function compteclient(){
        return $this->hasMany(CompteClient::class);
    }

    public function adresselivraison(){
        return $this->hasMany(AdresseLivraison::class);
    }

    public function codepostal(){
        return $this->hasMany(CodePostal::class);
    }
}
