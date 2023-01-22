<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CompteClient extends Model
{
    use HasFactory;

    protected $fillable = [
        "email",
        "password",
        "nom",
        "prenom",
        "adresse_client",
        "tel",
        "indicatif_tel",
        "tel_portable",
        "indicatif_tel_portable",
        "newsletter_miliboo",
        "newsletter_partenaire",
        "point_fidelite",
        "num_carte",
        "date_exp",
        "cryptogramme",
        "client_pro"
    ];

    //JAMAIS DEFINIR LES FOREIGN DANS LE FILLABLE

    //ENVOIE CLE A AUTRE TABLE
    //hasOne -> une biere a une marque
    //hasMany -> une biere a plusieurs marque

    //CLE ETRANGERE
    //belongsTo -> appartiens a
    //belongsToMany -> appartiens a plusieurs

    public function civilite(){
        return $this->belongsTo(Civilite::class);
    }

    public function pays(){
        return $this->belongsTo(Pays::class);
    }

    public function codepostal(){
        return $this->belongsTo(CodePostal::class);
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }

    public function adresselivraison(){
        return $this->hasMany(AdresseLivraison::class);
    }

    public function avis(){
        return $this->hasMany(Avis::class);
    }

    public function photoproduit(){
        return $this->hasMany(PhotoProduit::class);
    }

    public function pivotderniereconsult(){
        return $this->hasMany(PivotDerniereConsult::class);
    }

    public function pivotproduitaime(){
        return $this->hasMany(PivotProduitAime::class);
    }

    public function commande(){
        return $this->hasMany(Commande::class);
    }
}
