function openModal(type){
    if(type === 'image'){
        $('#lightBoxModal1').modal('show');
    }

    if(type === 'video'){
        $('#lightBoxModal2').modal('show');
    }

}

function closeModal(){
    $('#lightBoxModal1').modal('hide');
    $('#lightBoxModal2').modal('hide');
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n, type) {
    showSlides(slideIndex += n, type);
}

function currentSlide(n, type) {
    showSlides(slideIndex = n, type);
}

function showSlides(n, type) {
    var i;
    var slides = document.getElementsByClassName("mySlides" + type);
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex-1].style.display = "block";
}
