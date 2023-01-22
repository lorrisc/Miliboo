//************** BUTTON EMAIL CHANGE POPUP
let buttonConfirmEmailSignup = document.querySelector("#displayPopupNewAccount");
buttonConfirmEmailSignup.addEventListener("click", () => {
    let errormailmessage = document.querySelector("#signupbase .errormessage");

    let mailvalue = document.querySelector("#signupbase #emailsignup");
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (mailvalue.value.match(validRegex)) {
        let signupPopup = document.querySelector("#signupPopup");
        let firstPopup = document.querySelector("#formContainer");
        signupPopup.classList.add("active");
        firstPopup.classList.add("desactive");
        errormailmessage.classList.remove("activate");

        let mailinputcopy = document.querySelector("#signupPopup__top #confirmemailsignup");
        mailinputcopy.value = mailvalue.value;
    } else {
        errormailmessage.classList.add("activate");
    }
});

//********** radio button particular / professional user
let proRadioButton = document.querySelector("#leftSignupPopup__userStatus #professionnal");
let particularRadioButton = document.querySelector("#leftSignupPopup__userStatus #particular");
let containerPro = document.querySelector("#leftSignupPopup__proForm");

proRadioButton.addEventListener("click", () => {
    containerPro.classList.add("active");
});
particularRadioButton.addEventListener("click", () => {
    containerPro.classList.remove("active");
});