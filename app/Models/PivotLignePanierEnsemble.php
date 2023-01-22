<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotLignePanierEnsemble extends Model
{
    use HasFactory;

    protected $fillable = [
        'qte'
    ];

    public function ensemble(){
        return $this->belongsTo(Ensemble::class);
    }

    public function commande(){
        return $this->belongsTo(Commande::class);
    }
}
