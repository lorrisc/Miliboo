<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReponseSociete extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_reponse'
        ];    	
    
    public function avis(){
        return $this->hasOne(Avis::class);
    }
}
