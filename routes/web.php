<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountLogController;
use App\Http\Controllers\AccountPasswordController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountLogoutController;
use App\Http\Controllers\AccountInfoPersoController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\ConfirmSMSController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ProduitsLikes;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//************ HOME
Route::get('/', [IndexController::class, "index"])->name('home');

//************ ACCOUNT
Route::get('/compte', [AccountController::class, "index"])->name('compte');

Route::get('/comptepro', [App\Http\Controllers\AccountProController::class, "index"])->name('comptepro');

//************ ACCOUNT INFO PERSO
Route::get('/compte_information_personnelles', [AccountInfoPersoController::class, "index"])->name('accountinfoperso');
Route::post('/compte_modification_information_personnelles', [AccountInfoPersoController::class, "editaccount"])->name('accountinfopersoedit');
Route::get('/compte_consultation_information_personnelles', [AccountInfoPersoController::class, "consultaccountinfo"])->name('consultaccountinfo');
Route::post('/newdelivery', [AccountInfoPersoController::class, "newdelivery"])->name('newdelivery');
Route::post('/deletedelivery/{id}',  [AccountInfoPersoController::class, "deletedelivery"])->name('newdelivery');
Route::get('/editdelivery/{id}',  [AccountInfoPersoController::class, "editdelivery"])->name('editdelivery');

//************ ACCOUNT LOG
Route::get('/connexion', [AccountLogController::class, "index"])->name('connexion');
Route::post('/createaccount', [AccountLogController::class, "store"])->name('createaccount');
Route::post('/connexionaccount',  [AccountLogController::class, "login"])->name('connexionaccount');
Route::get('/connexionDirecteur',  [AccountLogController::class, "vente"])->name('connexionDirecteur');

//************ SMS CONFIRM
Route::get('/smsConfirm',  [ConfirmSMSController::class, "index"])->name('smsConfirm');
Route::get('/smsConfirmWrong',  [ConfirmSMSController::class, "index"])->name('smsConfirmWrong');

//************ ACCOUNT PRO ONLY
Route::get('/consultations', [App\Http\Controllers\ConsultationsController::class, "index"])->name('consultations');
Route::get('/detailproduits', [App\Http\Controllers\DetailProduct::class, "index"])->name('detailproduct');
Route::get('/nouvelleboutique', [App\Http\Controllers\NouvelleBoutique::class, "index"])->name('nouvelleboutique');
Route::post('/addShop', [App\Http\Controllers\NouvelleBoutique::class, "addShop"])->name('addShop');
Route::get('/editproducts/{id}/{idCouleur}', [App\Http\Controllers\EditProductsController::class, "edit"])->name('editproducts');
Route::get('/commandes/{id}/emporte', [App\Http\Controllers\ConsultationsController::class, "updateEmporte"])->name('commandes.updateEmporte');

//************ ACCOUNT ¨PASSWORD
Route::get('/compte_password',  [AccountPasswordController::class, "index"])->name('accountpassword');
Route::post('/edit_password', [AccountPasswordController::class, "editpassword"])->name('edit_password');

//************ SEARCH RESULTS
Route::post('/recherche', [ResultController::class, "index"])->name('recherche');

// Route::get('/categorie/{id}', [CategoryController::class, "viewcategories"])->name('id_category');
Route::get('/categorie/{id}', [CategoryController::class, "viewcategories"])->name('id_category');
// Route::get('/categorie/{id}/{matiere}/{idCouleur}', [CategoryController::class, "viewcategories"])->name('id_category');
Route::post('/categoriefilter/{id}', [CategoryController::class, "viewcategoriesfilter"])->name('categoriefilter');

Route::get('/promotion', [ResultController::class, "promotion"])->name('promotion');
Route::get('/madeinfrance', [ResultController::class, "madeinfrance"])->name('madeinfrance');
Route::get('/boutique_miliboo', [BoutiqueController::class, "index"])->name('boutique_miliboo');

Route::get('/nouveautes', [ResultController::class, "nouveautes"])->name('nouveautes');

Route::post('/filtrer',  [ResultController::class, "filtrer"])->name('filtrer');

Route::get('/likes',  [ResultController::class, "likes"])->name('likes');
Route::get('/likesnotconnected', [App\Http\Controllers\NotConnectedController::class, "index"])->name('likesnotconnected');

//************ PRODUCT PAGE
Route::get('/produit/{id}/{libProduit}/{idCouleur}', [ProductController::class, "produit"])->name('produit');
Route::get('/produit/{id}', [ProductController::class, "showResponse"])->name('product');

//************ RESULTAT PERSONNEL
Route::get('/ventesparmois', [App\Http\Controllers\ResultatVentesController::class, "ventesparmois"])->name("ventesparmois");
Route::get('/ventesparcategories/{mois}/{année}', [App\Http\Controllers\ResultatVentesController::class, "ventesparcategories"])->name("ventesparcategories");



//************ SHOPPING CART
Route::post('/ajouterproduit/{productid}/{colorid}',  [ShoppingCartController::class, "addProduct"])->name('removeProduct');
Route::post('/retirerproduit/{marketproductid}',  [ShoppingCartController::class, "removeProduct"])->name('removeProduct');
Route::post('/modifierqteproduit/{marketproductid}',  [ShoppingCartController::class, "changeQuantityProduct"])->name('changeQuantityProduct');
Route::get('/supprimerpanier',  [ShoppingCartController::class, "removeAllProducts"])->name('removeAllProducts');

Route::get('/fidelityPointAdd/{totalprice}/{fidelitypoint}',  [MarketController::class, "fidelityPointAdd"])->name('fidelityPointAdd');

//see market
Route::get('/monpanier',  [MarketController::class, "index"])->name('monpanier');
//command etap 2
Route::post('/commande',  [MarketController::class, "commande"])->name('commande');
Route::get('/commandespassees',  [App\Http\Controllers\MarketController::class, "commandespassees"])->name('commandespassees');



//************ LOG OUT
Route::get('/logout',  [AccountLogoutController::class, "logout"])->name('logout');

//************ PROTECTION DES DONNEES
Route::get('/protectiondesdonnees',  [App\Http\Controllers\ProtectionDesDonneesController::class, "protectiondesdonnees"])->name('protectiondesdonnees');
Route::get('/politiquecookies', [App\Http\Controllers\CookiesPageInfoController::class, 'controllerCookiesInfoPage'])->name('politiquecookies');
Route::get('/besoin-aide', [App\Http\Controllers\BesoinAideController::class, 'besoinAide'])->name('besoin-aide');
Route::get('/anonymisation', [App\Http\Controllers\AnonymisationController::class, 'anonymisation'])->name('anonymisation');


//*********** SMS */
Route::post('/sms/{id}', [App\Http\Controllers\SmsController::class, 'sendSms'])->name('/sms');

Route::get('/modifyLivraison/{id}', [App\Http\Controllers\modifyLivraison::class, 'index'])->name('/modifyLivraison/{id}');


// Route::get('protectiondesdonnees', function(){
//     return view('/ressoursces/views/protectiondesdonnees');
// });

// adlaurent@gmail.fr

// ad@ad.add
// ad@ad.ad123AZE$

//exemplemail@exemplemail.com
//exemplemail@exemplemail.com123A£


//test.test@t.t
//test.test@t.t13/*A

//yugcuyklsv@gmail.c
//imel@imel.c12/*A


//monpremiercompte@cg.c
//monpremiercompte@cg.c13/*A


//baril.george@gmail.com123/*A

//adil.nath@tristan.fr

//mdp sms : 152894