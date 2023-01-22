<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_livreur'
        ];    	
    
    public function produit(){
        return $this->hasMany(Produit::class);
    }
}
