//* DISPLAY CATEGORY ON HOVER
let navbar = document.querySelector("#navCat");
let navbarCategories = document.querySelectorAll("#navCat__top button");
let allCategoryContainer = document.querySelector("#navCat__hiddenCats");
let categoryContainer = document.querySelectorAll(
    "#navCat__hiddenCats .navCat__hiddenCat__Category"
);
let principalContainer = document.querySelector(".principalContainer");

for (let i = 0; i < navbarCategories.length; i++) {
    navbarCategories[i].addEventListener("mouseenter", () => {
        for (let j = 0; j < navbarCategories.length; j++) {
            categoryContainer[j].classList.remove("active");
        }
        categoryContainer[i].classList.add("active");
        allCategoryContainer.classList.add("active");
        principalContainer.classList.add("navbarIsActive");
    });
    navbar.addEventListener("mouseleave", () => {
        categoryContainer[i].classList.remove("active");
        allCategoryContainer.classList.remove("active");
        principalContainer.classList.remove("navbarIsActive");
    });
}

//* DISPLAY INFORMATION ON HOVER RIGHT BUTTON
let buttons = document.querySelectorAll("#top__right a");
let infoButtons = document.querySelectorAll("#top__right a > div");
for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("mouseenter", () => {
        infoButtons[i].classList.add("active");
        let rect = infoButtons[i].getBoundingClientRect();
        let transformpixelvalue = -rect.width / 2 + 25;
        infoButtons[i].style.transform =
            "translateX(" + transformpixelvalue + "px)";
    });
    buttons[i].addEventListener("mouseleave", () => {
        infoButtons[i].classList.remove("active");
    });
}

let fauteilbureau = document.querySelector("#fauteilbureau");
fauteilbureau.addEventListener("click", () => {
    window.location.assign("/recherche");
});

//*CLOSE ERROR MESSAGE
let errormessageClosebutton = document.querySelector(
    ".errorContainer .closeButton"
);
if (errormessageClosebutton) {
    errormessageClosebutton.addEventListener("click", () => {
        let errormessage = document.querySelector(".errorContainer");
        errormessage.classList.add("close");
    });
}
//*CLOSE SUCESS MESSAGE
let suuccessmessageClosebutton = document.querySelector(
    ".sucessMessage .closeButton"
);
if (suuccessmessageClosebutton) {
    suuccessmessageClosebutton.addEventListener("click", () => {
        let successmessage = document.querySelector(".sucessMessage");
        successmessage.classList.add("close");
    });

    document.addEventListener("scroll", (event) => {
        let successmessage = document.querySelector(".sucessMessage");
        successmessage.classList.add("close");
    });
}
