var $collectionImageHolder;

// setup an "add a tag" link
var $addImageLink = $('<a href="#" class="btn btn-default">Ajouter une image</a>');
var $newLinkDiv = $('<div></div>').append($addImageLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionImageHolder = $('div#trick_trickImages');

    // add the add image to the collection
    $collectionImageHolder.append($newLinkDiv);

    addImageForm($collectionImageHolder, $newLinkDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionImageHolder.data('index', $collectionImageHolder.find(':input').length);

    $addImageLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form
        addImageForm($collectionImageHolder, $newLinkDiv);
    });
});

function addImageForm($collectionImageHolder, $newLinkDiv) {
    // Get the data-prototype explained earlier
    var prototype = $collectionImageHolder.data('prototype');

    // get the new index
    var index = $collectionImageHolder.data('index');

    var newForm = prototype;

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionImageHolder.data('index', index + 1);

    // Display the form in the page in an div, before the "Add a tag" link div
    var $newFormDiv = $('<div></div>').append(newForm);
    $newLinkDiv.before($newFormDiv);
}