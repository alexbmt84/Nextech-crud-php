document.querySelector('.delete-button').addEventListener('click', function(e) {

    var r = confirm("Êtes-vous sûr de vouloir supprimer votre compte?\nCette action est irréversible.");
    
    if (!r) {
        e.preventDefault();
    }

});