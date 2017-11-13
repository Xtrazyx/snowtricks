var $collectionVideoHolder;

// setup an "add a tag" link
var $addVideoLink = $('<a href="#" class="btn btn-default">Vidéo supplémentaire</a>');
var $newLinkVideoDiv = $('<div class="form-group"></div>').append($addVideoLink);

jQuery(document).ready(function() {
    // Get the the collection
    $collectionVideoHolder = $('div#trick_videos');

    // add the add video to the collection
    $collectionVideoHolder.append($newLinkVideoDiv);
    
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionVideoHolder.data('index', $collectionVideoHolder.find(':input').length);

    $collectionVideoHolder.find('div.video-form').each(function (index) {
        if(index > 0){
            addDelVideoLink($(this));
        }
    });

    if($('div.video-form').length === 0){
        addVideoForm($collectionVideoHolder, $newLinkVideoDiv);
    }

    $addVideoLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form
        addVideoForm($collectionVideoHolder, $newLinkVideoDiv);
    });
});

function addVideoForm($collectionVideoHolder, $newLinkVideoDiv) {
    // Get the data-prototype explained earlier
    var prototype = $collectionVideoHolder.data('prototype');

    // get the new index
    var index = $collectionVideoHolder.data('index');

    var newVideoForm = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newVideoForm = newVideoForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionVideoHolder.data('index', index + 1);

    // Display the form in the page in an div, before the "Add a tag" link div
    var $newFormDiv = $('<div class="form-group"></div>').append(newVideoForm);
    if($('div.video-form').length > 0){
        addDelVideoLink($newFormDiv);
    }

    $newLinkVideoDiv.before($newFormDiv);
}

function addDelVideoLink($form){
    var $delVideoLink = $('<a href="#" class="btn btn-default">Supprimer la vidéo</a>');
    $form.append($delVideoLink);

    $delVideoLink.on('click', function(e) {
        e.preventDefault();

        $form.remove();
    })
}