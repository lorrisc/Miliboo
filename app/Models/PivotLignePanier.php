<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotLignePanier extends Model
{
    use HasFactory;

    protected $fillable = [
        'qte'
    ];

    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    public function commande(){
        return $this->belongsTo(Commande::class);
    }

    public function couleur(){
        return $this->belongsTo(Color::class);
    }
}
