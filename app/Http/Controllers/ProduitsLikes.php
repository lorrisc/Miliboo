<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProduitsLikes extends Controller
{
    //
    public function index($id)
    {
        $l = [];
        if(isset($_GET['like']))
        {
            array_push($l, $_GET['like']);
            $position = count($l);
            setcookie('likes['.$position.']', $id, time() + 1000000);
        }    

    }
}
