<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Commande;

class ConsultationsController extends Controller
{
    
    public function index(Request $request)
    {

        $commandes = [];

        if (isset($request['Date']) && $request['Date'] == 'Heure prochaine') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');
            $limitdate = Carbon::now()->addHours(2)->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '>', $currentdate)
            ->where('date_commande', '<=', $limitdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else if (isset($request['Date']) && $request['Date'] == 'Demi journée prochaine') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');
            $limitdate = Carbon::now()->addHours(13)->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '>', $currentdate)
            ->where('date_commande', '<=', $limitdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else if (isset($request['Date']) && $request['Date'] == 'Journée prochaine') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');
            $limitdate = Carbon::now()->addHours(25)->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '>', $currentdate)
            ->where('date_commande', '<=', $limitdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else if (isset($request['Date']) && $request['Date'] == '3 prochains jours') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');
            $limitdate = Carbon::now()->addHours(73)->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '>', $currentdate)
            ->where('date_commande', '<=', $limitdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else if (isset($request['Date']) && $request['Date'] == 'Deux semaines prochaines') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');
            $limitdate = Carbon::now()->addHours(337)->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '>', $currentdate)
            ->where('date_commande', '<=', $limitdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else if (isset($request['Date']) && $request['Date'] == 'Deja passées') 
        {
            $currentdate = Carbon::now()->format('Y-m-d, H:i:s');

            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->where('date_commande', '<=', $currentdate)
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }

        else 
        {
            $commandes = Commande::select('commandes.id', 'produits.lib_produit', 'compte_client_id', 'paiements.type_paiement', 'livreurs.nom_livreur', 'instruction', 'livraison_express', 'statut_commande', 
            'date_commande', 'transports.lib_transport', 'emporte')
            ->join('pivot_ligne_paniers', 'commandes.id', 'pivot_ligne_paniers.commande_id')
            ->join('produits', 'pivot_ligne_paniers.produit_id', 'produits.id')
            ->join('transports', 'transports.id', 'commandes.transport_id')
            ->join('paiements', 'paiements.id', 'commandes.paiement_id')
            ->leftJoin('livreurs', 'livreurs.id', 'commandes.livreur_id')
            ->distinct('commandes.id')
            ->get()->toArray();
     
            // $commandes = Commande::select('produits.lib_produit', 'compte_client', 'paiement_id', 'livreur_id', 'instruction', 'livraison_express', 'statut_commande', 
            // 'date_commande', 'transport.lib_transport')
        }




        $commandesliv = [];

        if (isset($request['livraison']) && $request['livraison'] == 'Livraison express')
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['livraison_express'] == true
                    || $commandes[$i]['livraison_express'] == 1)
                {
                    array_push($commandesliv, $commandes[$i]);
                }
            }
        }

        else if (isset($request['livraison']) && $request['livraison'] == 'Livraison normale uniquement')
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['livraison_express'] == false
                    || $commandes[$i]['livraison_express'] == 0
                    || $commandes[$i]['livraison_express'] == null)
                {
                    array_push($commandesliv, $commandes[$i]);
                }
            }
        }
        else
        {
            $commandesliv = $commandes;
        }

        $commandes = $commandesliv;







        $commandesmode = [];

        if (isset($request['Mode']) && $request['Mode'] == 'camion')
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['lib_transport'] == 'camion')
                {
                    array_push($commandesmode, $commandes[$i]);
                }
            }
        }

        else if (isset($request['Mode']) && $request['Mode'] == 'Deux roues')
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['lib_transport'] == 'Deux roues')
                {
                    array_push($commandesmode, $commandes[$i]);
                }
            }
        }
        else if (isset($request['Mode']) && $request['Mode'] == 'Autre mode de transport')
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['lib_transport'] == 'Autre mode de transport')
                {
                    array_push($commandesmode, $commandes[$i]);
                }
            }
        }
        else
        {
            $commandesmode = $commandes;
        }

        $commandes = $commandesmode;

       

        $commandestransport = [];

        if (isset($request['Transport']) && $request['Transport'] == 'Depôt' && (count($commandes) <> 0))
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                 if ($commandes[$i]['nom_livreur'] == null)
                {
                    array_push($commandestransport, $commandes[$i]);
                }
            }
        }

        else if (isset($request['Transport']) && $request['Transport'] == 'Transport à domicile' && (count($commandes) <> 0))
        {
            foreach (range(0, count($commandes) - 1) as $i)
            {
                if ($commandes[$i]['nom_livreur'] <> null)
                {
                    array_push($commandestransport, $commandes[$i]);
                }
            }
        }
        else
        {
            $commandestransport = $commandes;
        }

        $commandes = $commandestransport;

        return view('consultation')->with('commandes', $commandes);


        return view('consultation');
    }

    public function updateEmporte(Request $request, $id)
    {
        // Récupération de la commande à mettre à jour par soon id
        $commande = Commande::findOrFail($id);
    
        // Mise à jour de la colonne emporte en fonction de la valeur de la checkbox
        if ($request->emporte == "1") {
            $commande->emporte = true;
        } else {
            $commande->emporte = false;
        }
    
        // Enregistrement de la modification en base de données
        $commande->save();
    
        // Redirection vers la page de consultation des commandes
        return redirect()->route('consultations');
    }
}
