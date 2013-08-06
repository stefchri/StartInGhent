/* 
 * ANSWERS.JS
 * 
 * Author Stefaan Christiaens <stefaan.ch@gmail.com>
 * 
 */
var _active = 1;
var _max = 12;
var alertM = false;
var _answers = {};
var _data = {};
var _hmdata = [];
var _wijken = {};
var _map;

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
            case "3":   console.log(3);
                        break;
                        
            //COMFORT
            case "4":   console.log(4);
                        break;
            case "5":   console.log(5);
                        break;
            case "6":   console.log(6);
                        break;
            case "7":   console.log(7);
                        break;
            case "8":   console.log(8);
                        break;
            case "9":   console.log(9);
                        break;
            case "10":   console.log(10);
                        break;
            case "11":   console.log(11);
                        break;
            case "12":   console.log(12);
                        break;
            
                
        }
    });
    placeMap();
}

function loadDataSets()
{
    $.getJSON(_baseUrl + "api/dataset", {}, function(data, status, jqXHR){
        $.each(data.datasets, function(i,v){
            for (key in v.value)
            {
                _data[key] = v;
            }
            
        });
        console.log(_data);
        $.each(data.datasets[0].value.Wijken, function(i,v){
           _wijken[v.wijk] = 0;
        });
    });
    
}

function getCenterPoint(coords, impact)
{
    //SPLIT COORDINATES FOR SEARCHING
    var coordsArray = coords.split(' ');
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
            yMin = v.lng;
        }
    });
    hmpoint = {};
    hmpoint["lat"] = xMin + ((xMax - xMin) / 2);
    hmpoint["lng"] = yMin + ((yMax - yMin) / 2);
    hmpoint["count"] = parseInt(impact);
    _hmdata.push(hmpoint);
}

function placeMap()
{
    var heatmap = new HeatmapOverlay(_map, {
        "radius":20,
        "visible":true, 
        "opacity":60
    });
    var testData={
            max: 99999,
            data: _hmdata
    };
    console.log(testData);
    heatmap.setDataSet(testData);
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
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    _map = new google.maps.Map(document.getElementById("gmap"),mapOptions);
}