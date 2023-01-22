function check()
{        
    var regexcodecarte = new RegExp('([0-9]{4}[-]){3}[0-9]{4}')
    var regexcryptogramme = new RegExp('[0-9]{3}')
    var regexexpiration = new RegExp('[0-9]{2}[-][0-9]{2}')

    let codecarte = getElementsById('codecarte');
    let cryptogramme = getElementsById('cryptogramme');
    let expiration = getElementsById('codecarte');

    if(codecarte.match(regexcodecarte) && cryptogramme.match(regexcryptogramme) && expiration.match(regexexpiration))
    {
        console.log(1);
        Location.href('/commande')
    }
    else
    {
        if(!codecarte.match(regexcodecarte))
        {
            <?php echo("<p>Le format de la carte de crédit n'est pas bon</p>") ?>
        }
        if(!cryptogramme.match(regexcryptogramme))
        {
            <?php echo("<p>Le format du cryptogramme n'est pas bon</p>") ?>
        }
        if(!expiration.match(regexexpiration))
        {
            <?php echo("<p>Le format de la date d'expiration n'est pas bon</p>") ?>
        }
    }
}