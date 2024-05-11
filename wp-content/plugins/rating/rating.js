'use strict';

jQuery(document).ready(function($) {

    const ratingRadios = $('input[type="radio"][name="rating"]');
    const labels = jQuery('#rating-form').parent().children('label');
    let selectedRating;

    ratingRadios.on('click', function() {
        selectedRating = $(this).val();
        $('#rating-form').submit();
    });

    jQuery('#rating-form').on('submit', function (evt) {
        evt.preventDefault();

        jQuery.ajax({
            type: "POST",
            url: rating_plugin.ajax_url,
            data: jQuery(this).serialize(),
            success: function(response) {
                if(response.success) {
                    jQuery('#rating-display').html(response.message);
                    jQuery('#rating-display').show();
                    labels.each(function (i) {
                        const star = jQuery(this).find('ion-icon');
                        if (i < selectedRating) {
                            star.attr('name', 'star');
                        } else {
                            star.attr('name', 'star-outline');
                        }
                    });
                } else {
                    alert('There was an error submitting your rating.');
                }
            },
            error: function() {
                alert('There was an error submitting your rating.');
            },
            dataType: 'json'
        });
    });
});