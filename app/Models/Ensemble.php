<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ensemble extends Model
{
    use HasFactory;

    protected $fillable = [
	'lib_ensemble',
	'prix_ensemble',
	'promo_ensemble'
    ];    	

    public function pivotunifier(){
        return $this->hasMany(PivotUnifier::class);
    }

    public function pivotlignepanierensemble(){
        return $this->hasMany(PivotLignePanierEnsemble::class);
    }
}
