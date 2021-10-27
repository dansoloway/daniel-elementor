jQuery(function($){
    $('body').on('click', '.gal_upload_image_button', function(e){   // add a gallery image
        e.preventDefault();
        var upload_button_id = this.id;  // id of clicked button

        var just_the_id = upload_button_id.split('upload_image_button');  // remove the surround text, get just the #id number
        var just_the_id =  just_the_id[1];
        var new_image_id = "gal_custom_image" + just_the_id;

        gal_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = gal_uploader.state().get('selection').first().toJSON();
            var attachment_url = attachment.url;
            //jQuery('.delete_admin_image').show();  //show delete button
            jQuery('#' + new_image_id).val(attachment.url);  // add to hidden field
            jQuery('#adminImagePreview' + just_the_id).attr("src", "" + attachment_url);  //preview URL
            jQuery('#delete_button' + just_the_id).show();  //show delete butto
        })
            .open();
    });

    $('body').on( 'click', '.delete_admin_image', function() {

        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var image = "gal_custom_image" + $(this).data('image');
        var switchout = "adminImagePreview" + $(this).data('image');
        var gallerycount = $(this).data('image')
        $.ajax({
            type: 'post',
            url: MyAjaxObj.ajaxurl,
            data: {
                action: 'delete_gal_image',
                nonce: nonce,
                id: id,
                image: image,
                gallerycount: gallerycount
            },
            success: function( result ) {

                if( result == 'success0' ) {
                    jQuery('#adminImagePreview' + gallerycount).attr("src", "" + MyAjaxObj.placeholderimg);  //preview URL
                    jQuery('#delete_button' + gallerycount).hide();
                }
                else{
                    alert("Error");
                }
            }
        })
        return false;
    })


});






