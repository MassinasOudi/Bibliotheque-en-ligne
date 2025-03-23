// Ajout d'une animation aux boutons
const buttons = document.querySelectorAll("button");
buttons.forEach(button => {
  button.addEventListener("mouseover", function() {
    this.style.transform = "scale(1.1)";
  });
  button.addEventListener("mouseout", function() {
    this.style.transform = "scale(1)";
  });
});
