//************ PASSWORD VERIFICATION
//user indication
let minchar = document.querySelector("#minchar");
let uppercase = document.querySelector("#uppercase");
let lowercase = document.querySelector("#lowercase");
let figure = document.querySelector("#chiffre");
let specialchar = document.querySelector("#specialchar");
let samepass = document.querySelector("#samepass");
const specialChars = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
//input
let passwordvalue = document.querySelector("#passwordfield");
let passwordvalueconfirm = document.querySelector("#passwordconfirmfield");

//event
passwordvalue.addEventListener("input", function() {
    validation(this);
});
passwordvalueconfirm.addEventListener("input", function() {
    if (this.value == passwordvalue.value) {
        samepass.classList.add("validate");
    } else {
        samepass.classList.remove("validate");
    }
});

function validation(password) {
    //same pass
    if (password.value == passwordvalueconfirm.value) {
        samepass.classList.add("validate");
    } else {
        samepass.classList.remove("validate");
    }
    
    //figure
    if (/[0-9]{1}/.test(password.value)) {
        figure.classList.add("validate");
    } else {
        figure.classList.remove("validate");
    }

    //uppercase
    if (/[A-Z]{1}/.test(password.value)) {
        uppercase.classList.add("validate");
    } else {
        uppercase.classList.remove("validate");
    }

    //lowercase
    if (/[a-z]{1}/.test(password.value)) {
        lowercase.classList.add("validate");
    } else {
        lowercase.classList.remove("validate");
    }

    //lenght
    if (password.value.length >= 12) {
        minchar.classList.add("validate");
    } else {
        minchar.classList.remove("validate");
    }

    //specialchar
    if (specialChars.test(password.value) == true) {
        specialchar.classList.add("validate");
    } else {
        specialchar.classList.remove("validate");
    }
}