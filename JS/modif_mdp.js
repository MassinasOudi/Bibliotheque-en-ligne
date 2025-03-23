// test de la longueur du mot de passe 
function test() {
    var newMdp = document.getElementById("newMdp");
    var message = document.getElementById("message");

    if (newMdp.value.length < 8) {
        message.textContent = "Le mot de passe doit contenir au "
        +" moins 8 caractères.";
        message.style.color = "red";
        return false;
    } else {
        message.textContent = "";
        return true;
    }
}

// test de la correspandence des mots de passe 
function testMatch() {
    var newMdp = document.getElementById("newMdp");
    var newMdp1 = document.getElementById("newMdp1");
    var message1 = document.getElementById("message1");

    if (newMdp.value !== newMdp1.value) {
        message1.textContent = "Les mots de passe ne correspondent pas.";
        message1.style.color = "red";
        return false;
    } else {
        message1.textContent = "";
        return true;
    }
}

function testMdp() {
    return test() && testMatch();
}

document.addEventListener("DOMContentLoaded", function() {
    var newMdp = document.getElementById("newMdp");
    var newMdp1 = document.getElementById("newMdp1");

    newMdp.addEventListener("input", test);
    newMdp1.addEventListener("input", testMatch);
});
