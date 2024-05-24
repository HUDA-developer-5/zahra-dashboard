//map
(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
            ({key: "AIzaSyDl02ktqMdvzEwH-_oa7RREoI8Gr-6c9eQ", v: "weekly"});
if($('#map').length != 0) {
    let map;
    let marker;
    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");

        var latitude = document.getElementById('latitude');
        var longitude = document.getElementById('longitude');
        if (latitude !== null) {
            latitude = parseFloat(latitude);
        }
        if (longitude !== null) {
            longitude = parseFloat(longitude);
        }
        if (!latitude || !longitude) {
            latitude = 30.033333;
            longitude = 31.233334;
        }

        var myLatLng = { lat: latitude, lng: longitude };


        map = new Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatLng,
            disableDefaultUI: true,
        });

        new google.maps.Marker({
            position: myLatLng,
            map: map
        });

        // Add a listener for the click event to add marker
        map.addListener('click', function(event) {
            // add longitude to hidden input
            $('#longitude').val(event.latLng.lng());
            // add latitude to hidden input
            $('#latitude').val(event.latLng.lat());
            placeMarker(event.latLng);
        });
    }

    function placeMarker(location) {
        // If a marker already exists, move it to the new location, otherwise create a new marker
        if (marker) {
            marker.setPosition(location);
        } else {
            // Create a marker and set its position
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }

        // Center the map on the marker's position
        map.setCenter(location);
    }

    initMap();
}