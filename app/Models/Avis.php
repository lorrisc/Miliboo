<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'titre_avis',
        'detail_avis',
        'date_avis'
        ];    	
    
    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }

    public function noteavis(){
        return $this->belongsTo(NoteAvis::class);
    }

    public function reponsesociete(){
        return $this->belongsTo(ReponseSociete::class);
    }

    public function photoproduit(){
        return $this->hasMany(PhotoProduit::class);
    }

    public function produit(){
        return $this->belongsTo(Produit::class);
    }
}
