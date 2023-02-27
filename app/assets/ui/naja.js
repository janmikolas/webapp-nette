import naja from "naja";
window.naja = naja;

// We must attach Naja to window load event.
document.addEventListener('DOMContentLoaded', () => naja.initialize({
    history: false,
}));

$(document).ready(function() {
    $('.modal').modal();
});

$(document).on("click", ".close", function() {
    $('.modal').hide();
});

$(document).keyup(function(e) {
    if (e.key === "Escape") {
        $('.modal').hide();
   }
});
