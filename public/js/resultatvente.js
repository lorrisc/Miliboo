let mois = document.getElementById("icone");
let soustab = document.getElementById("icone2");
let lesmois = document.querySelectorAll(".mois");
let bout = document.querySelector("button");

bout.addEventListener("click", () => {
    mois.style.display = "block";
    soustab.style.display = "none";
});

lesmois.forEach((element) =>
    element.addEventListener("click", () => {
        mois.style.display = "none";
        soustab.style.display = "block";
    })
);
