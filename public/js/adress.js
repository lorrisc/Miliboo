function create(tag, parent, text = null, classs = null, id = null) {
    let element = document.createElement(tag);

    if (text) element.appendChild(document.createTextNode(text));
    parent.appendChild(element);
    if (classs) element.classList.add(classs);
    if (id) element.id = id;

    return element;
}

let fetchadress = document.querySelectorAll(".fetchaddress");
let address = document.querySelectorAll(".fetchaddressresult");
let postalzip = document.querySelectorAll(".fetchopstalzipresult");
let city = document.querySelectorAll(".fetchcityresult");
for (let i = 0; i < fetchadress.length; i++) {
    fetchadress[i].addEventListener("change", () => {
        addressFunc(fetchadress[i].value, address[i], postalzip[i], city[i]);
    });
}

function addressFunc(fetchaddress, address, postalzip, city) {
    let addressuser = fetchaddress;
    let url =
        "https://api-adresse.data.gouv.fr/search/?q=" +
        addressuser +
        "&limit=5";
    fetch(url, { method: "get" })
        .then((response) => response.json())
        .then((results) => {
            document.body.classList.add("noscroll");
            popupadress.classList.add("active");
            backgroundpopup.classList.add("display");
            backgroundpopup.classList.add("twopopup");

            let divtop = create("div", popupadress, null, "toplinepopupadress");
            let titlepopup = create(
                "h2",
                divtop,
                "Veuillez sélectionner votre adresse :"
            );

            let closebutton = create("button", divtop, null, "closeButton");
            closebutton.setAttribute("type", "reset");

            let line1close = create("div", closebutton);
            let line2close = create("div", closebutton);

            let i = 0;
            results.features.forEach((element) => {
                i++;
                console.log(element.properties);

                let resultcontainer = create("div", popupadress);

                let radioinput = create(
                    "input",
                    resultcontainer,
                    null,
                    null,
                    "input" + i
                );
                radioinput.setAttribute("type", "radio");
                radioinput.setAttribute("name", "address" + i);
                radioinput.setAttribute("value", element.properties.label);
                radioinput.setAttribute("name", "address");

                let labelinput = create(
                    "label",
                    resultcontainer,
                    element.properties.label
                );
                labelinput.setAttribute("for", "input" + i);
            });

            let buttonvalidation = create(
                "div",
                popupadress,
                "Valider",
                "normalbutton"
            );

            function deletecontainer() {
                popupadress.classList.remove("active");
                backgroundpopup.classList.remove("display");
                // delete container childs
                firstChild = popupadress.firstChild;
                while (firstChild) {
                    popupadress.removeChild(firstChild);
                    firstChild = popupadress.firstChild;
                }

                document.body.classList.remove("noscroll");
            }

            closebutton.addEventListener("click", () => {
                deletecontainer();
            });
            buttonvalidation.addEventListener("click", () => {
                let indexadress = null;
                let j = 0;
                results.features.forEach((element) => {
                    if (element.properties.label == popupadress.address.value) {
                        indexadress = j;
                    }
                    j++;
                });

                postalzip.setAttribute(
                    "value",
                    results.features[indexadress].properties.postcode
                );

                city.setAttribute(
                    "value",
                    results.features[indexadress].properties.city
                );

                address.setAttribute(
                    "value",
                    results.features[indexadress].properties.name
                );

                deletecontainer();
            });
        })
        .catch((error) => {
            let addresserror = document.querySelector("#addresserror");
            addresserror.classList.add("activate");
            throw error;
        });
}

// CREATE POPUP
let popupadress = create("form", document.body, null, "popupadress", null);
console.log(popupadress);
let backgroundpopup = create(
    "div",
    document.body,
    null,
    "backgroundpopup",
    null
);
