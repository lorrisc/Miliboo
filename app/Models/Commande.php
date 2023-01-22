<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'compte_client_id',
        'paiement_id',
        'livreur_id',
        'instruction',
        'livraison_express',
        'statut_commande',
        'date_commande',
        'fidelity_use',
        'id_adresse',
        'emporte'
        ];    	
    
    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }
        
    public function paiement(){
        return $this->belongsTo(Paiement::class);
    }
    public function livreur(){
        return $this->belongsTo(Livreur::class);
    }

    public function pivotlignepanier(){
        return $this->hasMany(PivotLignePanier::class);
    }

    public function transport(){
        return $this->belongsTo(Transport::class);
    }
}
