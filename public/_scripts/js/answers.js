/* 
 * ANSWERS.JS
 * 
 * Author Stefaan Christiaens <stefaan.ch@gmail.com>
 * 
 */
var _active = 1;
var _max = 11;
var alertM = false;
var _answers = {};
var _data = {};
var _hmdata = [];
var _map;
var _heatmap;

//NAVIGATION
function start(){
    $("#answers-title .row .span12").animate({"margin-left":"-=2000px"}, 1000, function(){
        $(this).parent().parent().hide(function(){
            $("#test").show();
        });
    });
    
    $(document).keydown(function(e){
        if (e.which == 37) { 
           previous();
           return false;
        }
        if (e.which == 39) { 
           next();
           return false;
        }
});
}

function showAnswer(id, dir)
{
    if (dir) 
        $(".question[data-question='"+ (id-1).toString() +"']").hide();
    else
        $(".question[data-question='"+ (id+1).toString() +"']").hide();
    $(".question[data-question='"+ id +"']").show();
}

function next()
{
    if(checkIfFilledIn())
    {
        if (_active !== _max) 
        {
            showAnswer(++_active, true);
            if (_active === _max)
               $(".next a").html("Finish"); 
            else
            {
                $(".next a").html("Next &rarr;");
                $(".previous").removeClass("disabled"); 
            }
        }
        else
        {
            finish();
        }
    }
    else
    {
        alertMsg();
    }
    
}

function previous()
{
    if (_active !== 1) 
    {
        showAnswer(--_active, false);
        if (_active === 1)
            $(".previous").addClass("disabled"); 
        else
        {
            $(".next").removeClass("disabled"); 
            $(".next a").html("Next &rarr;");
        }
    }
    else
    {
        $(".previous").addClass("disabled");
    }
}

function checkIfFilledIn()
{
    var flag = false;
    $(".question[data-question='" + _active + "'] input[type='radio']").each(function(i,v){
        if ($(v).is(':checked')) {
            flag = true;
        }
    });
    return flag;
}

function alertMsg()
{
    if (!alertM) {
        var msg =   '<div class="alert fade in span12">'+
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>Hey there!</strong> You can only switch questions if you answered this one.'+
                '</div>';
        $("#test").append(msg);
        $(".alert").alert();
        setTimeout(function () {
            $(".alert").alert('close');
            alertM = false;
        }, 3000);
        alertM = true;
    }
    
}

function finish()
{
    $(".question").each(function(index,value){
        var number = $(value).data("question");
        _answers[number] = $(value).find("input[type='radio']:checked").first().val();
    });
    $("#test").hide();
    
    $("#map_span").show();
    initializeMap();
    analyseAnswers();
    saveAnswers();
}

function analyseAnswers()
{
    $.each(_answers, function(ind, va){
        switch(ind)
        {
            //AGE
            case "1":   //DOES NOTHING YET
                        break;
                     
            //PARKS
            case "2":   
                    if(va != "2")
                    {
                        var set = _data["Parken"].value.Parken;
                        $.each(set, function(i,v){
                            getCenterPoint(v.coords, 1);
                        }); 
                    }
                    break;
           
            //KIDS
            case "3":   
                    if (va != 5 && va != 2) {
                        parsePoints(_data["Basisscholen"].value.Basisscholen, false);
                        parsePoints(_data["SecundaireScholen"].value.SecundaireScholen, false);
                        var set = _data["Speelterreinen"].value.Speelterreinen;
                        $.each(set, function(i,v){
                            getCenterPoint(v.coords, 1);
                        });
                    }
                    break;
                        
            //BUURTCENTRA
            case "4": 
                    if (va != 2) {
                        parsePoints(_data["Buurtcentra"].value.Buurtcentra, false);
                    }
                    break;
                        
            //TRAIN
            case "5":   
                    if (va == 0) {
                        parsePoints(_data["stationsgent"].value.stationsgent, false);
                    }
                    break;
                        
            //BIB            
            case "6":   
                    if (va == 1) {
                        parsePoints(_data["Bibliotheek"].value.Bibliotheek, false);
                    }
                    break;
                        
            //SPORT
            case "7":   
                    if (va == 1 || va ==0) {
                        parsePoints(_data["Sportcentra"].value.Sportcentra, false);
                    }
                    break;
            
             
            //GARAGE
            case "8":   
                    if (va == 1) {
                        parsePoints(_data["parkings"].value.parkings, false);
                    }
                    break;
                    
            //OCMW
            case "9":   
                    if (va == 0) {
                        parsePoints(_data["Welzijnsbureaus"].value.Welzijnsbureaus, true);
                    }
                    break;
                    
            //DOGS        
            case "10":   
                    if (va == 0) {
                        parsePointsDogs(_data["Hondenvoorzieningen"].value.Hondenvoorzieningen);
                    }
                    break;
                        
            //CINE            
            case "11":   
                    if (va == 1) {
                        parsePoints(_data["Bioscopen"].value.Bioscopen, false);
                    }
                    break;
            
                
        }
    });
    placeMap();
}

function loadDataSets()
{
    //CHECK FOR LOCALSTORAGE
    var flag = false;
    if (Modernizr.localstorage)
    {
        flag = getData();
    }
    
    if(!flag)
    {
        $.getJSON(_baseUrl + "api/dataset", {}, function(data, status, jqXHR){
            $.each(data.datasets, function(i,v){
                for (key in v.value)
                {
                    _data[key] = v;
                }
            });
            saveData(data);
        });
    }
    
}

function getData()
{
    if (localStorage.getItem("startinghent.datasets") !== null) {
        console.log("data found!");
        var jsonData = $.parseJSON(localStorage["startinghent.datasets"]);
        $.each(jsonData.datasets, function(i,v){
            for (key in v.value){_data[key] = v;}
        });return true;
    }
    else
        return false;
}

function saveData(data)
{
    if (Modernizr.localstorage)
    {
        console.log("data stored");
        localStorage["startinghent.datasets"] = JSON.stringify(data);
    }
}

function getCenterPoint(coords, impact)
{
    //SPLIT COORDINATES FOR SEARCHING
    var coordsArray = coords.split(' ');
    coordsArray.pop();
    var coLL = [];
    $.each(coordsArray, function(i,v)
    {
        var co = {};
        co["lat"] = v.split(",")[1];
        co["lng"] = v.split(",")[0];
        coLL.push(co);
    });
    //SEARCH FOR MIN AND MAX VALUES
    var xMin = coLL[0].lat;
    var xMax = coLL[0].lat;
    var yMin = coLL[0].lng;
    var yMax = coLL[0].lng;
    $.each(coLL, function(i,v)
    {
        if (xMin > v.lat) {
            xMin = v.lat;
        }
        if (xMax < v.lat) {
            xMin = v.lat;
        }
        if (yMin > v.lng) {
            yMin = v.lng;
        }
        if (yMax < v.lng) {
            yMax = v.lng;
        }
        
        
    });
    hmpoint = {};
    var lat = parseFloat(xMin) + ((xMax - xMin) / 2);
    var lng = parseFloat(yMin) + ((yMax - yMin) / 2);
    
    
    hmpoint["lat"] = lat;
    hmpoint["lng"] = lng;
    hmpoint["count"] = parseInt(1);
    _hmdata.push(hmpoint);
}

function parsePoints(points, dataFromGhent)
{
   $.each(points, function(i,v){
        hmpoint = {};
        if (dataFromGhent) {
            hmpoint["lat"] = (v.latitude).split(',').join(".");
            hmpoint["lng"] = (v.longitude).split(',').join(".");
        }
        else
        {
            hmpoint["lat"] = v.lat;
            hmpoint["lng"] = v.long;
        }
        hmpoint["count"] = parseInt(1);
        _hmdata.push(hmpoint);
   }); 
}

function parsePointsDogs(points)
{
   $.each(points, function(i,v){
        hmpoint = {};
        if (v.soort == "Hondentoilet")
        {
            hmpoint["lat"] = (v.lat).split(',').join(".");
            hmpoint["lng"] = (v.long).split(',').join(".");
        }
        hmpoint["count"] = parseInt(1);
        _hmdata.push(hmpoint);
   }); 
}

function placeMap()
{
    _heatmap = new HeatmapOverlay(_map, {
        "radius":80,
        "visible":true,
        "opacity": 90
    });
    
    var testData={
        max: 10,
        data: _hmdata
    };
 
    // now we can set the data
    google.maps.event.addListenerOnce(_map, "idle", function(){
        // this is important, because if you set the data set too early, the latlng/pixel projection doesn't work
        _heatmap.setDataSet(testData);
    });
    
}

function saveAnswers()
{
    if (_loggedin) {
        var postdata = {"id":id, "answers": _answers};
        $.ajax({
           type: "POST",
           data: {"data" : JSON.stringify(postdata)},
           url: _baseUrl + "api/user"
        });
    }
}

$(document).ready(function()
{
    $(".question").each(function(ind,val){
        if ($(val).data('question') === 1) 
            $(val).show();
        else
            $(val).hide();
    });
    $(".previous").addClass("disabled");
    
    loadDataSets();
});

function initializeMap()
{
    var mapOptions = {
          center: new google.maps.LatLng(51.0625664653974, 3.76548313370094),
          zoom: 11,
          panControl: false,
          zoomControl: true,
          draggable: false,
          minZoom: 11,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    _map = new google.maps.Map(document.getElementById("gmap"),mapOptions);
}