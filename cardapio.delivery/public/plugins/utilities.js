(function ($) {
    window.scrollToActiveElement = function (className) {
        const activeElement = document.querySelector(className);

        if (activeElement) {
            activeElement.scrollIntoView({
                behavior: 'smooth'
            });
        }
    };


    // check addtocart validation
    window.validateForm = function () {

        var select_at_least = $('#select_at_least').attr('href');
        var options = $('#options').attr('href');

        var isValid = true;

        $('.item_extra_list.required-section').each(function () {
            var section = $(this);
            var requiredCount = parseInt(section.data('limit'));
            var inputs = section.find('.extras:checked');

            if (inputs.length < requiredCount) {
                isValid = false;
                section.find('.errorMessage').text(`${select_at_least} ${requiredCount} ${options}`);
                scrollToActiveElement('.errorMessage');
            } else {
                section.find('.errorMessage').text('');
            }
        });
        setTimeout(() => {
            $('.errorMessage').html('');
        }, 4000);

        return isValid;
    }


    /*----------------------------------------------
         GET LATITUDE & LONGITUDE
   ----------------------------------------------*/

    window.getLocation = function () {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                if ($('[name="latitude"]').length > 0) {
                    $('[name="latitude"]').val(latitude);
                }

                if ($('[name="longitude"]').length > 0) {
                    $('[name="longitude"]').val(longitude);
                }
                console.log("Latitude: " + latitude + ", Longitude: " + longitude);
            }, function (error) {
                console.error("Error getting geolocation:", error);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    }

    window.addLangToUrl = function (url) {
     var languageType = $('meta[name="language_type"]').attr('content');
     if(languageType == 'system'){
        const lang = $('html').attr('lang');
        if (!lang) return url;
        if (url.indexOf('lang=') === -1) {
            if (url.indexOf('?') === -1) {
                return `${url}?lang=${lang}`;
            } else {
                return `${url}&lang=${lang}`;
            }
        }
    }
    
    return url;
}


})(jQuery);