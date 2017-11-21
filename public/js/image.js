// Modal open
$('#addImage').click(function () {
    $('#ModalImageAdd').modal('show');
});

// Manage form submit and server response
$('#addImageForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/manage_image',
        data: new FormData(this),
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function(html){
            $('.img-list').append(html);
            $('#ModalImageAdd').modal('hide');
            $('#libModal').modal('show');
        },
        error: function(){
            alert("Une erreur s'est produite durant l'envoi des données.")
        }
    });
});

function deleteImage(id) {
    $.ajax({
        url: '/manage_image',
        data: {
            imageId: id,
            actionType: 'delete'
        },
        type: 'POST',
        success: function(){
            $('#img_'+id).hide();
        },
        error: function(){
            alert("Une erreur s'est produite durant l'envoi des données.")
        }
    });
}
