$(function(){
    // lightbox
    $(document).ajaxStop(function() {
        initLightbox();
    });
    initLightbox();

    $(document).on('click', '#gallery-container .pagination li a', function(e){
        e.preventDefault();
        var page       = $(this).attr('data-page');
        var gallery_id = $('#gallery-container').attr('data-id');
        
        var url_to_call = baseurl + '/cms/galleries/renderajaxgallery?id='+gallery_id+'&page='+page
        
        $.ajax({
            url: url_to_call,
            type: 'POST',
            success: function(data) {
                $('#gallery-container').hide().fadeOut('slow').fadeIn('slow').html(data);
                load_other_images();
            }
        });
    });
    
    //további képek betöltése, ha van container
    if ($('#gallery-container .pagination').length > 0){
        load_other_images();
    }
});

function initLightbox(){
    $('a[data-rel^=lightbox][data-rel$="]"], a[data-rel=lightbox]').magnificPopup({
        gallery: {
            enabled: true
        },
        type: 'image',
        tClose: 'Bezárás',
        callbacks: {
            open: function() {
                // Will fire when this exact popup is opened
                // this - is Magnific Popup object
                //add_other_image_to_right();
            },
            close: function() {
                // Will fire when popup is closed
            }
            // e.t.c.
        }
    });
    return false;
}

function load_other_images(){
    var gallery_id  = $('#gallery-container').attr('data-id');
    var active_page = $('#gallery-container .pagination li.active a').attr('data-page');
    // ehhez a galéria id-hoz kell betölteni a többi képet
    var url_to_call = baseurl + '/cms/galleries/loadotherimages?id='+gallery_id+'&activePage='+active_page;

    $.ajax({
        url: url_to_call,
        type: 'GET',
        success: function(data) {
            var results = jQuery.parseJSON(data);

            $.each(results, function(i, item){
                switch(i){
                    case 'before':
                        $('#gallery-'+gallery_id+'-before').html(item);
                        break;
                    case 'after':
                        $('#gallery-'+gallery_id+'-after').html(item);
                        break;
                }
            });

            initLightbox();
        }
    });
}