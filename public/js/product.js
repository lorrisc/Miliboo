addEventListener("load", (event) => {
    let listeEtoiles = document.querySelectorAll('.choisisEtoile');
    let popUpPhotoBG = document.querySelector('.backgroundpopup');
    let starSelector = 2;

    setCookie('LiaisonJsPhp', starSelector, dtExpire, '/' );

    for (let i = 0; i < listeEtoiles.length; i++) {
        listeEtoiles[i].addEventListener('click', (event) => {

            switch (listeEtoiles[i]) {
                case listeEtoiles[0]:
                    starSelector = 1

                    listeEtoiles[0].classList.remove("fa-regular");
                    listeEtoiles[1].classList.remove("fa-solid");
                    listeEtoiles[2].classList.remove("fa-solid");
                    listeEtoiles[3].classList.remove("fa-solid");

                    listeEtoiles[0].classList.add("fa-solid");
                    listeEtoiles[1].classList.add("fa-regular");
                    listeEtoiles[2].classList.add("fa-regular");
                    listeEtoiles[3].classList.add("fa-regular");
                    console.log(1)
                    break;
                case listeEtoiles[1]:
                    starSelector = 2

                    listeEtoiles[0].classList.remove("fa-regular");
                    listeEtoiles[1].classList.remove("fa-regular");
                    listeEtoiles[2].classList.remove("fa-solid");
                    listeEtoiles[3].classList.remove("fa-solid");

                    listeEtoiles[0].classList.add("fa-solid");
                    listeEtoiles[1].classList.add("fa-solid");
                    listeEtoiles[2].classList.add("fa-regular");
                    listeEtoiles[3].classList.add("fa-regular");
                    console.log(2)
                    break;
                case listeEtoiles[2]:
                    starSelector = 3

                    listeEtoiles[0].classList.remove("fa-regular");
                    listeEtoiles[1].classList.remove("fa-regular");
                    listeEtoiles[2].classList.remove("fa-regular");
                    listeEtoiles[3].classList.remove("fa-solid");

                    listeEtoiles[0].classList.add("fa-solid");
                    listeEtoiles[1].classList.add("fa-solid");
                    listeEtoiles[2].classList.add("fa-solid");
                    listeEtoiles[3].classList.add("fa-regular");
                    console.log(3)
                    break;
                case listeEtoiles[3]:
                    starSelector = 4

                    listeEtoiles[0].classList.remove("fa-regular");
                    listeEtoiles[1].classList.remove("fa-regular");
                    listeEtoiles[2].classList.remove("fa-regular");
                    listeEtoiles[3].classList.remove("fa-regular");

                    listeEtoiles[0].classList.add("fa-solid");
                    listeEtoiles[1].classList.add("fa-solid");
                    listeEtoiles[2].classList.add("fa-solid");
                    listeEtoiles[3].classList.add("fa-solid");
                    console.log(4)
                    break;
                default:
                    console.log('NON');
            }

            function setCookie(nom, valeur, expire, chemin, domaine, securite){
            document.cookie = nom + ' = ' + escape(valeur) + '  ' +
                      ((expire == undefined) ? '' : ('; expires = ' + expire.toGMTString())) +
                      ((chemin == undefined) ? '' : ('; path = ' + chemin)) +
                      ((domaine == undefined) ? '' : ('; domain = ' + domaine)) +
                      ((securite == true) ? '; secure' : '');
            }
       
            var dtExpire = new Date();
            dtExpire.setTime(dtExpire.getTime() + 3600 * 500);
       
            setCookie('LiaisonJsPhp', starSelector, dtExpire, '/' );
        });
    };


    console.log(popUpPhotoBG)
});