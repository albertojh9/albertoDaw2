/* ========================================
   SCRIPT PARA EL BOTÓN FLOTANTE
   Este código hace que el botón "subir" aparezca 
   cuando el usuario hace scroll hacia abajo
   ======================================== */

// Función autoejecutable para encapsular el código
(function () {
    // Variable que define a partir de qué punto (en píxeles) se mostrará el botón
    // Si el usuario hace scroll más de 115px, el botón aparece
    const ishow = 115;
    
    // Obtener el elemento del botón flotante por su ID
    const $divtop = document.getElementById("div-totop");
    
    // Añadir un evento que se ejecuta cada vez que el usuario hace scroll
    window.addEventListener("scroll", function () {
        // Comprobar si el scroll vertical es mayor que 115px
        if (document.documentElement.scrollTop > ishow) {
            // Mostrar el botón (cambiando su display a "inherit")
            $divtop.style.display = "inherit";
        } else {
            // Ocultar el botón (cambiando su display a "none")
            $divtop.style.display = "none";
        }
    });
})();

