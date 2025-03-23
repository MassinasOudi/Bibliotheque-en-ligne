const profil = document.querySelector(".profil");

// Ajout de la date
const date = document.createElement("p");
const now = new Date();
date.textContent = `Date actuelle : ${now.toLocaleDateString()}`;
date.style.textAlign = "right";
date.style.fontWeight = "bold";
document.body.insertBefore(date, profil);

// Ajout d'une animation hover aux boutons
const buttons = document.querySelectorAll("button");
buttons.forEach(button => {
  button.addEventListener("mouseover", function() {
    this.style.transform = "scale(1.05)";
  });
  button.addEventListener("mouseout", function() {
    this.style.transform = "scale(1)";
  });
});
