var $collectionVideoHolder;

// setup an "add a tag" link
var $addVideoLink = $('<a href="#" class="btn btn-default">Ajouter une vidéo</a>');
var $newLinkVideoDiv = $('<div></div>').append($addVideoLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionVideoHolder = $('div#trick_videos');

    // add the add image to the collection
    $collectionVideoHolder.append($newLinkVideoDiv);

    addVideoForm($collectionVideoHolder, $newLinkVideoDiv);
    
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionVideoHolder.data('index', $collectionVideoHolder.find(':input').length);

    $addVideoLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form
        addImageForm($collectionVideoHolder, $newLinkVideoDiv);
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
    var $newFormDiv = $('<div></div>').append(newVideoForm);
    $newLinkVideoDiv.before($newFormDiv);
}