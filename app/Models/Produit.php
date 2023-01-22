<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'lib_produit',
        'commentaire_entretien',
        'qte_produit',
        'd_tot_longueur',
        'd_tot_profondeur',
        'd_tot_largeur',
        'd_dos_longueur',
        'd_dos_profondeur',
        'd_dos_largeur',
        'd_ass_hauteur',
        'revetement',
        'matiere',
        'matiere_pieds',
        'type_mousse_assise',
        'type_mousse_dossier',
        'densite_assise',
        'densite_dossier',
        'd_long_colis',
        'd_prof_colis',
        'd_haut_colis',
        'poids_max',
        'd_poids_colis',
        'epaisseur_assise',
        'd_deplie_longueur',
        'd_deplie_largeur',
        'd_deplie_profondeur',
        'longueur_accoudoir',
        'profondeur_accoudoir',
        'hauteur_accoudoir'
    ];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    
    public function parentproduit(){
        return $this->belongsTo(Produit::class);
    }
    
    public function photoproduit(){
        return $this->hasMany(PhotoProduit::class);
    }
    
    public function avis(){
        return $this->hasMany(Avis::class);
    }
    
    public function pivotunifier(){
        return $this->hasMany(PivotUnifier::class);   
    }

    public function pivotlignepanier(){
        return $this->hasMany(PivotLignePanier::class);
    }
    
    public function pivotderniereconsult(){
        return $this->hasMany(PivotDerniereConsult::class);
    }
    
    public function pivotproduitaime(){
        return $this->hasMany(PivotProduitAime::class);
    }

    public function mention(){
        return $this->belongsTo(Mention::class);
    }
}
