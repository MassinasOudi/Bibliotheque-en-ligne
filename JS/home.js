// Animation de texte de bienvenue
document.addEventListener("DOMContentLoaded", function() {
    
    const intro = document.querySelector(".introduction h2");
    let text = intro.innerHTML;
    intro.innerHTML = "";
    let i = 0;

    function write() {
        if (i < text.length) {
            intro.innerHTML += text.charAt(i);
            i++;
            setTimeout(write, 100);
        }
    }
    write();
});
