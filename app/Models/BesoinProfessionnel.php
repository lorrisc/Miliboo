<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BesoinProfessionnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_societe',
        'num_tva',
        'nom_prenom',
        'email',
        'adresse_bsn_pro',
        'code_postal',
        'ville',
        'pays',
        'tel',
        'message'
        ];    	
    
    public function sujetbesoinpro(){
        return $this->belongsTo(SujetBesoinPro::class);
    }

    public function activitepro(){
        return $this->belongsTo(ActivitePro::class);
    }
}
