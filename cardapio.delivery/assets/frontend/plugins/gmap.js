(function () {
    var locatorSection = document.getElementById("locator-input-section")
    var input = document.getElementsByClassName("autocomplete");
    var gmap = document.getElementById("gmapKey");
    let gmapKey = gmap.getAttribute("href"); 




    var button = document.getElementById("locator-button");
    button.addEventListener("click", function() {
        locatorSection.classList.add("loading");
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log('geolocation...');
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            geocodeLatLng(latitude,longitude);

        }, function(error) {
            console.log(error);
            console.error("Error getting location:", error.message);
        });

    });

    async function geocodeLatLng(latitude, longitude) {
        const latlng = {
            lat: latitude,
            lng: longitude,
        };
        const geocoder = new google.maps.Geocoder();
        try {
            const response = await geocoder.geocode({location: latlng});
            setAddressToInputField(response.results); 
        } catch (e) {
            window.alert(`Geocoder failed due to: ${e}`);
        }
    }



    function setAddressToInputField(address) {
        var ad = '';
        address.forEach((element) => {
            $('.es-list, .autocomplete').append(`
                <li>${element.formatted_address}</li>
                `);

        });

        $(".autocomplete").val(address[0].formatted_address);
        input.value = address[0].formatted_address;
        // input.value = address
        locatorSection.classList.remove("loading")
    }




    $(document).on('click','.es-list li',function(){
       var val = $(this).text();
       $('.autocomplete').val(val);
   });


    function showError(error) {
        var x = $('#editable-select');
        switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
        }}

    })();


