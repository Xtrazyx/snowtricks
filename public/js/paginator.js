jQuery(document).ready(function() {
    var $pagination = $('#paginator');
    var defaultOpts = { totalPages: 20 };
    $pagination.twbsPagination(defaultOpts);
    $.ajax({
        url: '/list_trick',
        type: 'GET',
        success: function (json) {
            var totalPages = json.nbPages;
            var currentPage = $pagination.twbsPagination('getCurrentPage');
            $pagination.twbsPagination('destroy');
            $pagination.twbsPagination($.extend({}, defaultOpts, {
                startPage: currentPage,
                totalPages: totalPages,
                hideOnlyOnePage: true,
                onPageClick: function (event, page) {
                    // Grab content page from Ajax request
                    $.ajax({
                        url: '/list_trick',
                        data: {
                            page: page
                        },
                        type: 'POST',
                        success: function (html) {
                            $('div#trick_list').html(html);
                        },
                        error: function () {
                            alert("Une erreur s'est produite durant l'envoi des données.")
                        }
                    })
                }
            }))
        }
    });
});