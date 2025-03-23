// Ajout de la date actuelle
const dateElement = document.createElement("p");
const now = new Date();
dateElement.textContent = `Date actuelle : ${now.toLocaleDateString()}`;
dateElement.style.textAlign = "right";
dateElement.style.fontWeight= "bold";
document.body.insertBefore(dateElement, document.body.firstChild);
