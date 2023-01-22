<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotProduitAime extends Model
{
    use HasFactory;

    protected $fillable = [
        'compte_client_id',
        'produit_id'
    ];

    protected $primaryKey = ['compte_client_id', 'produit_id'];

    public $incrementing = false;

    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }
}
