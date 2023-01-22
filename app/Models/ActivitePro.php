<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitePro extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_activite'
        ];    	
    
    public function besoinprofessionnel(){
        return $this->hasMany(BesoinProfessionnel::class);
    }
}
