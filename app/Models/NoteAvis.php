<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteAvis extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_avis'
        ];    	
    
    public function avis(){
        return $this->hasMany(Avis::class);
    }
}
