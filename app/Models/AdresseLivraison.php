<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdresseLivraison extends Model
{
    use HasFactory;

    protected $fillable = [
        'ville_id',
        'civilite_id',
        'compte_client_id',
        'pay_id',
        'code_postal_id',
        'nom_adresse',
        'nom',
        'prenom',
        'adresse_livraison',
        'tel',
        'indicatif_tel',
        'tel_portable',
        'indicatif_tel_portable'
        ];    	
    
    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }

    public function codepostal(){
        return $this->belongsTo(CodePostal::class);
    }

    public function pays(){
        return $this->belongsTo(Pays::class);
    }

    public function civilite(){
        return $this->belongsTo(Civilite::class);
    }
}
