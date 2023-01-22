let body = document.querySelector("body")
let popupbackground = document.querySelector(".backgroundpopup")
//********** */ PERSONAL INFORMATION POPUP
let displayPopupPersonalInfoButton = document.querySelector("#buttonEditPersonalInfo");
displayPopupPersonalInfoButton.addEventListener("click", () => {
    let closebutton = document.querySelector("#popup__infoperso__classic .closeButton")
    let popupPersonalInfo = document.querySelector("#popup__infoperso__classic")
    popupPersonalInfo.classList.add("display")
    popupbackground.classList.add("display")
    body.classList.add("noscroll")
    
    closebutton.addEventListener("click", () => {
        popupPersonalInfo.classList.remove("display")
        popupbackground.classList.remove("display")
        body.classList.remove("noscroll")
    })
})
//********** */ NEW DELIVERY INFORMATION POPUP
let displayPopupNewDeliveryButton = document.querySelector("#adddelivery");
displayPopupNewDeliveryButton.addEventListener("click", () => {
let closebutton = document.querySelector("#infopersodelivery__containerpopup__newdelivery .closeButton")
    let popupNewdelivery = document.querySelector("#infopersodelivery__containerpopup__newdelivery")
    popupNewdelivery.classList.add("display")
    popupbackground.classList.add("display")
    body.classList.add("noscroll")

    closebutton.addEventListener("click", () => {
        popupNewdelivery.classList.remove("display")
        popupbackground.classList.remove("display")
        body.classList.remove("noscroll")
    })
})
//********** */ EDITS DELIVERIES INFORMATION POPUP
let displayPopupEditsDeliveriesButton = document.querySelectorAll(".editdelivery");
for (let i = 0; i < displayPopupEditsDeliveriesButton.length; i++) {
    displayPopupEditsDeliveriesButton[i].addEventListener("click", () => {
        
        let closebuttonedit = document.querySelectorAll("#infopersodelivery__containerpopup__editdeliveries .closeButton")
        let popupEditdeliveries = document.querySelectorAll(".infopersodelivery__containerpopup__editdeliveries")
        popupEditdeliveries[i].classList.add("display")
        popupbackground.classList.add("display")
        body.classList.add("noscroll")

        closebuttonedit[i].addEventListener("click", () => {
            popupEditdeliveries[i].classList.remove("display")
            popupbackground.classList.remove("display")
            body.classList.remove("noscroll")
        })
    })
}


