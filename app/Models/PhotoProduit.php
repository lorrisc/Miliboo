<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        "url_photo_produit"
    ];
    
    public function produit(){
        return $this->belongsTo(Produit::class);
    }
    
    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }

    public function avis(){
        return $this->belongsTo(Avis::class);
    }

    public function couleur(){
        return $this->belongsTo(Couleur::class);
    }
}
