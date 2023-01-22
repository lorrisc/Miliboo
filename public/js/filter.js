let croissant = document.querySelector('#croissant')
let decroissant = document.querySelector('#decroissant')
let productContainer = document.querySelectorAll('.productContainer');
let price = document.querySelectorAll('.price');

// croissant.addEventListener("click", () => {
//     let tableauTrie = [];
//     for (let i = 0; i < price.length; i++) {
//         console.log(price[i].textContent);

    
//     }
// })

const numbers = [13,8,2,21,5,1,3,1];
const byValue = (a,b) => a - b;
const sorted = [...numbers].sort(byValue);
console.log(sorted);