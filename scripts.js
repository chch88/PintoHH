$(".button-collapse").sideNav();


// POUR LE SELECT
$(document).ready(function() {
    $('select').material_select();
});


// POUR LE COLLAPSE BAR
$(document).ready(function(){
    $('.collapsible').collapsible({
        accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
});

// POUR LE MODAL - FICHE DU BAR
$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
});

// Pour les maps
$(document).ready(function() {

    $("#map").addClass('hide');

    $('#mycheckbox').change(function() {
        if($(this).is(":checked")) {
            $("#map").removeClass('hide');

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 48.175066, lng: 6.4493356},
                    zoom: 15,
                    scrollwheel: false
                });

                google.maps.event.trigger(map, 'resize');
            $("#liste").addClass('hide');
            return;
        }
        $("#map").addClass('hide');
        $("#liste").removeClass('hide');
        return;
    });
});



$(document).ready(function(){
    $('.carousel').carousel();
});


// Next slide
$('.carousel').carousel('next');
$('.carousel').carousel('next', 3); // Move next n times.
// Previous slide
$('.carousel').carousel('prev');
$('.carousel').carousel('prev', 4); // Move prev n times.
// Set to nth slide
$('.carousel').carousel('set', 4);

$('.carousel.carousel-slider').carousel({full_width: true});



