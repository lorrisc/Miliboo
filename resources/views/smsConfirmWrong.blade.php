@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="/css/smsconfirm.css">
@endsection

@section('title')
Pretection des données
@endsection

@section('content')

<section>
    <form method="GET">
        <div>
            <h1 id="numero">Code envoyé au <?php echo session()->get('telport') ?></h1>
            <h2 id="numero">Le code rentré ne correspond pas à celui envoyé sur votre téléphone.</h2>
            <input id="sub" type="text" placeholder="Code reçu" name="code"></input>
            <br>
            <input id="subbutton" type="submit" value="Confirmer"></input>
        </div>
    </form>
</section>
@endsection