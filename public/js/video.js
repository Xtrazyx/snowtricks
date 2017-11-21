// Modal open
$('#addVideo').click(function () {
    $('#ModalVideoAdd').modal('show');
});

// Manage form submit and server response
$('#addVideoForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/manage_video',
        data: new FormData(this),
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        success: function(html){
            $('.vid-list').append(html);
            $('#ModalVideoAdd').modal('hide');
            $('#libModal').modal('show');
        },
        error: function(){
            alert("Une erreur s'est produite durant l'envoi des données.")
        }
    });
});

function deleteVideo(id) {
    $.ajax({
        url: '/manage_video',
        data: {
            videoId: id,
            actionType: 'delete'
        },
        type: 'POST',
        success: function(){
            $('#vid_'+id).hide();
        },
        error: function(){
            alert("Une erreur s'est produite durant l'envoi des données.")
        }
    });
}
