<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_categorie',
        'photo_path',
        'descr_cat',
        ];    	
    
    public function produit(){
        return $this->hasMany(Produit::class);
    }

    public function parentcategorie(){
        return $this->belongsTo(Categorie::class);
    }
}
