<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SujetBesoinPro extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_sujet'
        ];    	
    
    public function besoinprofessionnel(){
        return $this->hasMany(BesoinProfessionnel::class);
    }
}
