<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodePostal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_cp'
        ];    	
    
    public function ville(){
        return $this->hasMany(Ville::class);
    }
    
    public function pays(){
        return $this->belongsTo(Pays::class);
    }
    
    public function compteclient(){
        return $this->hasMany(CompteClient::class);
    }

    public function adresselivraison(){
        return $this->hasMany(AdresseLivraison::class);
    }
}
