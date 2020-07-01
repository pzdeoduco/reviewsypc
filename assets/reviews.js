jQuery(function() {
    
    jQuery('.review-stars-header').after("<div class='rating-stars'><ul class='mb-0' id='stars'><li class='star' title='Poor' data-value='1' data-desc='\"Really Needs Improvement!\"'> <i class='fa fa-star fa-fw'></i></li><li class='star' title='Fair' data-value='2' data-desc='\"Not Satisfied.\"'> <i class='fa fa-star fa-fw'></i></li><li class='star' title='Good' data-value='3' data-desc='\"OK experience, but...\"'> <i class='fa fa-star fa-fw'></i></li><li class='star' title='Excellent' data-value='4' data-desc='\"Very satisfied.\"'> <i class='fa fa-star fa-fw'></i></li><li class='star' title='WOW!!!' data-value='5' data-desc='\"Excellent! Very Satisfied.\"'> <i class='fa fa-star fa-fw'></i></li></ul><p class='text-center mb-0'><em class='rating-desc'>&nbsp;</em></p><div class='boldBtn btnAccent btnSmall'><button id='next-step-btn'>NEXT STEP</button></div></div>");


    jQuery('#next-step-btn').hide();
    jQuery('#low-score-segment').hide();
    jQuery('#high-score-segment').hide();
    

    var lastClickedStar = 0;
    var lastClickedDesc = '&nbsp;';

    /* 1. Visualizing things on Hover - See next part for action on click */
    jQuery('#stars li').on('mouseover', function() {
        var onStar = parseInt(jQuery(this).data('value'), 10); // The star currently mouse on
        var onDescription = jQuery(this).data('desc');


        jQuery('.rating-desc').html('<span>' + onDescription + '</span>');

        // Now highlight all the stars that's not after the current hovered star
        jQuery(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
                jQuery(this).addClass('hover');
            } else {
                jQuery(this).removeClass('hover');
            }
        });

    }).on('mouseout', function() {

        jQuery('.rating-desc').html('<span>' + lastClickedDesc + '</span>');

        jQuery(this).parent().children('li.star').each(function(e) {
            jQuery(this).removeClass('hover');
        });
    });


    /* 2. Action to perform on click */
    jQuery('#stars li').on('click', function() {
        jQuery('#next-step-btn').show();

        var onStar = parseInt(jQuery(this).data('value'), 10); // The star currently selected
        var stars = jQuery(this).parent().children('li.star');
        var onDescription = jQuery(this).data('desc');

        lastClickedDesc = onDescription;
        lastClickedStar = onStar;

        for (i = 0; i < stars.length; i++) {
            jQuery(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            jQuery(stars[i]).addClass('selected');
        }

    });


    /* NEXT BUTTON */

    jQuery('#next-step-btn').on('click', function() {
        jQuery('#stars li').css('pointer-events', 'none');

        if(lastClickedStar <= 3) {
            jQuery('#low-score-segment').show();
    
        } else {
            jQuery('#high-score-segment').show();
        }

        jQuery('#next-step-btn').css('display', 'none');
    });


});