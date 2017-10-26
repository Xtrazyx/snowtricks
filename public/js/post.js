// Manage form submit and server response
$('button#post').on('click', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/post',
        data: {
            content: $('input#post_content').val(),
            trick_id: $('#trick_id').val()
        },
        type: 'POST',
        success: function(html){
            $('div#new_post').append(html);
            $('input#post_content').text('');
        },
        error: function(){
            alert("Une erreur s'est produite durant l'envoi des données.")
        }
    });
});