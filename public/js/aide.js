function toggleElement(id) {
  var element = document.getElementById(id);
  if (element.style.display === "none") {
    element.style.display = "block";
  } else {
    element.style.display = "none";
  }
}

var image = document.getElementById("interrogation");
image.addEventListener("click", function() {
  toggleElement("mon-element");
});

toggleElement("myDialog")
