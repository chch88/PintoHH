<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test geoloc</title>
</head>
<body>

<div id="error" style="color: red"></div>
<form onsubmit="return false;">
    Adresse <input name="adresse"><br>
    Ville <input name="ville">
    <button>OK</button>
</form>
<span id="lat"></span> / <span id="lng"></span>
<br>
<br>
<button id="distance">Distance par rapport à moi</button>
<h2></h2>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
    $(function () {
        $("form").submit(function () {
            // recupere l'adresse postale
            var adresse = $(this).find('[name=adresse]').val();
            var ville = $(this).find('[name=ville]').val();

            adresse = adresse.replace(/ /g, '+');

            adresse = adresse + ',' + ville;

            // clé api
            var apiKey = 'AIzaSyBCAOGM2PURw7HTiLBxlN6dBixLnCoWBcM';
            // utilise Geocoder
            $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + adresse + '&key=' + apiKey,
                    function (data) {

                        if (data.status != 'OK') {
                            $("#error").text(data.status);
                            return;
                        }

                        var coords = data.results[0].geometry.location;
                        var lat = coords.lat;
                        var lng = coords.lng;
                        $("#lat").text(lat);
                        $("#lng").text(lng);
                    });

            // calcul distance par rapport à notre position
            $("#distance").click(function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    $("#error").text("Geolocation is not supported by this browser.");
                }
                function showPosition(position) {

                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    var stringlat = $("#lat").html();
                    var numlat = parseFloat(stringlat);
                    var stringlng = $("#lng").html();
                    var numlng = parseFloat(stringlng);

                    // trigo avec usercoords & adress coords
                    var Clat = userLat - numlat;
                    var Clng = userLng - numlng;
                    if (Clat < 0) {
                        Clat = Math.abs(Clat);
                        console.log(Clat);
                    }
                    if (Clng < 0) {
                        Clng = Math.abs(Clng);
                        console.log(Clng);
                    }

                    var Clat2 = Math.pow(Clat, 2);
                    var Clng2 = Math.pow(Clng, 2);

                    console.log(Clat2);console.log(Clng2);

                    var AB2 = Clat2 + Clng2;
                    console.log(typeof AB2);
                    console.log(AB2);

                    var distanceDeg = Math.sqrt(AB2);
                    console.log(distanceDeg);

                    var km = distanceDeg * 111.11;
                    console.log(km);

                }
            })
        })
    });

</script>
</body>
</html>