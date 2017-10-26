// Loading screen for Ajax request
$body = $('body');
$(document).bind({
    ajaxStart: function(){
        $body.addClass('loading');
    },
    ajaxStop: function(){
        $body.removeClass('loading');
    }
});