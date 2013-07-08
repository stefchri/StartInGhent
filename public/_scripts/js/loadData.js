var Googlemap;
var data;
var markers = [];
var kotzones = [];
var latlngs = [];
$(document).ready(function(){
    
})

function getData(el){
    var url = window.location.pathname;
    url = url.substring(0, url.length-1);
    var tags = url.split('/');
   
    if (tags[tags.length-1] == "public") {
        
       
        
        switch (el) {
            case 1:
                    parseJson("http://data.appsforghent.be/poi/basisscholen.json");
                break;
            case 2:
                    parseJson("http://data.appsforghent.be/poi/ziekenhuizen.json");
                break;
            case 3:
                    parseJson("http://data.appsforghent.be/poi/bioscopen.json");
                break;
            case 4:
                    parseJson("http://data.appsforghent.be/poi/dierenartsen.json");
                break;
            case 5:
                    parseJson("http://data.appsforghent.be/poi/kotzones.json");
                break;
            case 6:
                    parseJson("http://data.appsforghent.be/poi/parkings.json");
                break;
            case 7:
                    parseJson("http://data.appsforghent.be/poi/secundairescholen.json");
                break;
            case 8:
                    parseJson("http://data.appsforghent.be/poi/gezondheidscentra.json");
                break;
            case 9:
                    parseJson("http://data.appsforghent.be/poi/bibliotheken.json");
                break;
            case 10:
                    parseJson("http://data.appsforghent.be/poi/apotheken.json");
                break;
            
            default:
                break;
        }

    
    }
}

function parseJson(url){
    var s = document.createElement('script');
    s.setAttribute('type','text/javascript');
    s.setAttribute('src',url+"?callback=parse");
    var b = document.getElementsByTagName('body')[0];
    b.appendChild(s);
}
function parse(data)
{
    Googlemap = window.Googlemap;
    data = data;
    
    if (data.dierenartsen) {
        console.log('dierenartsen');
        parseVets(data.dierenartsen);
    }
    if (data.basisscholen) {
        console.log('basisscholen');
        parsePrimarySchools(data.basisscholen);
    }
    if (data.ziekenhuizen) {
        console.log('ziekenhuizen');
        parsehospitals(data.ziekenhuizen);
    }
    if (data.bioscopen) {
        console.log('bioscopen');
                parseCinemas(data.bioscopen);

    }
    if (data.kotzones) {
        console.log('kotzones');
         parseStudenthousings(data.kotzones);
    }
    if (data.parkings) {
        console.log('parkings');
        parseParkings(data.parkings);
    }
    if (data.secundairescholen) {
        console.log('secundairescholen');
        parseHighSchools(data.secundairescholen);
    }
    if (data.gezondheidscentra) {
        console.log('gezondheidscentra');
        parseCentra(data.gezondheidscentra);
    }
    if (data.bibliotheken) {
        console.log('bibliotheken');
        
        parseLibraries(data.bibliotheken);
    }
    if (data.apotheken) {
        console.log('apotheken');
        parseApoth(data.apotheken);
    }
}

function clearMap(){
    for (var i = 0; i < markers.length; i++ ) {
    markers[i].setMap(null);
  }
    for (var i = 0; i < kotzones.length; i++ ) {
    kotzones[i].setMap(null);
  }
}

function parseVets(vets)
{
    clearMap();
    markers =[];
    console.log(vets);
    $.each(vets, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.adres + " " + val.huisnr
        })
        markers.push(m);
    })
    
}
function parsePrimarySchools(schools)
{
    clearMap();
    markers =[];
    console.log(schools);
    $.each(schools, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.roepnaam + ": " + val.straat
        })
        markers.push(m);
    })
    
    
}
function parsehospitals(hospitals)
{
    clearMap();
    markers =[];
    console.log(hospitals);
    $.each(hospitals, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.naam + ": " + val.straat + " " + val.nr
        })
        markers.push(m);
    })
    
    
}
function parseCinemas(cinemas)
{
    clearMap();
    markers =[];
    console.log(cinemas);
    $.each(cinemas, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.naam
        })
        markers.push(m);
    })
    
    
}
function parseStudenthousings(sth)
{
    clearMap();
    markers =[];
    console.log(sth);
    $.each(sth, function(key,val){
        var c = val.coords;
        var d = c.split(' ');
        latlngs = [];
        $.each(d, function(k,v){
            var q = v.split(',');
            var latlng = new google.maps.LatLng(q[1],q[0]);
            latlngs.push(latlng);
        })
        
        var z = new google.maps.Polygon({
            paths: latlngs,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
            name: sth.kotzone_na
          });

 z.setMap(Googlemap);
 kotzones.push(z);
 
//        v
//        ar m = new google.maps.Marker({
//            position: new google.maps.LatLng(val.lat,val.long), 
//            map: Googlemap, 
//            title: val.naam
//        })
//        markers.push(m);
    })
    
 

  
    
    
}
function parseParkings(parkings)
{
    clearMap();
    markers =[];
    console.log(parkings);
    $.each(parkings, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.nr_p + ": " + val.naam
        })
        markers.push(m);
    })
    
    
}
function parseHighSchools(schools)
{
    clearMap();
    markers =[];
    console.log(schools);
    $.each(schools, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.naam + ": " + val.adres
        })
        markers.push(m);
    })
    
    
}
function parseCentra(centra)
{
    clearMap();
    markers =[];
    console.log(centra);
    $.each(centra, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.naamgzc + ": " + val.adres
        })
        markers.push(m);
    })
    
    
}
function parseLibraries(libs)
{
    clearMap();
    markers =[];
    console.log(libs);
    $.each(libs, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.afdeling + ": " + val.locatie
        })
        markers.push(m);
    })
    
    
}
function parseApoth(apoths)
{
    clearMap();
    markers =[];
    console.log(apoths);
    $.each(apoths, function(key,val){
        var m = new google.maps.Marker({
            position: new google.maps.LatLng(val.lat,val.long), 
            map: Googlemap, 
            title: val.naam + ": " + val.adres
        })
        markers.push(m);
    })
    
    
}

