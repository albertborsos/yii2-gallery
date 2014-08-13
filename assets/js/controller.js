$(function(){
    $(document).on('click', '.gallery-pager', function(e){
        e.preventDefault();
        var page       = $(this).attr('data-page');
        var gallery_id = $('#gallery-container').attr('data-id');
        
        var url_to_call = baseurl + '/cms/galleries/renderajaxgallery?id='+gallery_id+'&page='+page;
        
        $.ajax({
            url: url_to_call,
            type: 'GET',
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

function load_other_images(){
    var gallery_id  = $('#gallery-container').attr('data-id');
    var active_page = $('#gallery-container .pagination li.active').attr('data-page');
    // ehhez a galéria id-hoz kell betölteni a többi képet
    var url_to_call = baseurl + '/cms/galleries/loadotherimages?gallery_id='+gallery_id+'&active_page='+active_page;

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