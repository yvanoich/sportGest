// Fonction pour afficher l'image prévisualisée
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.profile-image').show();
            $('#existingImage').hide();
            $('#previewImage').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}