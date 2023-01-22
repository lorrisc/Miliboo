<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotUnifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'prix',
        'promo',
        'textDescr'
        ];
        
    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    
    public function ensemble(){
        return $this->belongsTo(Ensemble::class);
    }

    public function couleur(){
        return $this->belongsTo(Couleur::class);
    }
}
