<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotDernieresConsult extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'compte_client_id'
    ];

    protected $primaryKey = ['produit_id', 'compte_client_id'];

    public $incrementing = false;

    public function produit(){
        return $this->belongsTo(Produit::class);
    }

    public function compteclient(){
        return $this->belongsTo(CompteClient::class);
    }
}
