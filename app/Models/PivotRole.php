<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotRole extends Model
{
    use HasFactory;

    protected $fillable = [
        ];
        
    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function personnel(){
        return $this->belongsTo(Personnel::class);
    }
}
