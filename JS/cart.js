const form = document.querySelector("form");

// Animation des bouttons
const buttons = document.querySelectorAll("button");
buttons.forEach(button => {
  button.addEventListener("mouseover", function() {
    this.style.transform = "scale(1.1)";
  });
  button.addEventListener("mouseout", function() {
    this.style.transform = "scale(1)";
  });
});

// Ajout de la date
const date = document.createElement("p");
const now = new Date();
date.textContent = `Date actuelle : ${now.toLocaleDateString()}`;
date.style.textAlign = "right";
date.style.color = "white";
date.style.fontWeight = "bold";
document.body.insertBefore(date, form);
