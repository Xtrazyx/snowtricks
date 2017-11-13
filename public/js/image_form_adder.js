var $collectionImageHolder;

// setup an "add a tag" link
var $addImageLink = $('<a href="#" class="btn btn-default">Image supplémentaire</a>');
var $newLinkDiv = $('<div class="form-group"></div>').append($addImageLink);

jQuery(document).ready(function() {
    // Get the collection
    $collectionImageHolder = $('div#trick_trickImages');

    // add the add image to the collection
    $collectionImageHolder.append($newLinkDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionImageHolder.data('index', $collectionImageHolder.find(':input').length);

    $collectionImageHolder.find('div.img-form').each(function (index) {
        if(index > 0){
            addDelImageLink($(this));
        }
    });

    if($('div.img-form').length === 0){
        addImageForm($collectionImageHolder, $newLinkDiv);
    }

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
    var $newFormDiv = $('<div class="form-group"></div>').append(newForm);
    if($('div.img-form').length > 0){
        addDelImageLink($newFormDiv);
    }

    $newLinkDiv.before($newFormDiv);
}

function addDelImageLink($form){
    var $delImageLink = $('<a href="#" class="btn btn-default">Supprimer l\'image</a>');
    $form.append($delImageLink);

    $delImageLink.on('click', function(e) {
        e.preventDefault();

        $form.remove();
    })
}