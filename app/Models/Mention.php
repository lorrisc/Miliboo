<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    use HasFactory;

    protected $fillable = [
        'mention',
        'url_photo_mention'
        ];   

        public function produit(){
            return $this->hasMany(Produit::class);
        }
}
