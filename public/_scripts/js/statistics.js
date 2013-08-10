/* 
 * STATISTICS OF STARTINGHENT SITE AND USERS
 * 
 * Author Stefaan Christiaens
 * copyright 2012-2013
 * 
 * All rights reserved
 */
var _answers = {1:[0,0], 2:[0,0,0], 3:[0,0,0,0,0,0], 4:[0,0,0], 5:[0,0], 6:[0,0,0], 7:[0,0,0,0], 8:[0,0,0], 9:[0,0], 10:[0,0,0], 11:[0,0]};
var _answersP = {
        1:[{points : 0},{points : 0}], 
        2:[{points : 0},{points : 0},{points : 0}], 
        3:[{points : 0},{points : 0},{points : 0},{points : 0},{points : 0},{points : 0}], 
        4:[{points : 0},{points : 0},{points : 0}], 5:[{points : 0},{points : 0}], 
        6:[{points : 0},{points : 0},{points : 0}], 
        7:[{points : 0},{points : 0},{points : 0},{points : 0}], 
        8:[{points : 0},{points : 0},{points : 0}], 
        9:[{points : 0},{points : 0}], 
        10:[{points : 0},{points : 0},{points : 0}], 
        11:[{points : 0},{points : 0}]
    }; 
var _usersAnswered = 0;
var _usersTotal;
var _pics = [];

$(document).ready(function(){
    getData();
    window.requestAnimFrame = (function(callback) {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60);
        };
    })();
});

function getData()
{
    $.getJSON(_baseUrl + "api/user", {}, function(data, status, jqXHR)
    {
        parseData(data);
    });   
}

function parseData(data)
{
    _usersTotal = data.users.length;
        
    $.each(data.users, function(i,v){
        //COUNT AND PERCENTAGE OF ANSWERS
        if (v.answers !== null) {
            for (key in v.answers)
            {
                //STORE BY KEY, ADD COUNT
                _answers[key][v.answers[key]]++;
            }
            _usersAnswered++;
        }
        //PROFILE PICTURES
        var person = {};
        person["name"] = v.username;
        if (v.avatar !== null) 
        {
            person["avatar"] = _baseUrl + "images/" + v.avatar;
        }
        else
        {
            person["avatar"] = _baseUrl + "_assets/img/person-placeholder.jpg";
        }
        _pics.push(person);
    });
    
    calculateData();
}

function calculateData()
{
    //CALCULATE PERCENTAGES
    for(var i = 1 ; i <= 11; i++)
    {
        for (var j = 0; j < _answers[i].length; j++)
        {
            var percentage = Math.round(_answers[i][j]*100/_usersAnswered);
            _answersP[i][j]["points"] = percentage;
            var canvas = document.createElement("canvas");
            canvas.setAttribute('data-canvas',i + "/"+j);
            var perc = document.createElement("p");
            perc.setAttribute("class", "percentage");
            var node = document.createTextNode(percentage + "% chose this answer.");
            perc.appendChild(node);
            $(".answer[data-question='"+ i +"']").find("div[data-answer='" + j + "']").first().append(canvas);
            $(".answer[data-question='"+ i +"']").find("div[data-answer='" + j + "']").first().append(perc);
        }
    }
    placeData();
}

function placeData()
{
    $(".total").html("There are already <strong>" + _usersTotal + "</strong> people using this webapplication to find their most suitable place to live in Ghent.")
    
    placeProfilePics();
    
    var canvass = document.getElementsByTagName('canvas');
    $.each(canvass, function(i,v){
        v.setAttribute('width', parseInt(50));
        v.setAttribute('height', parseInt(50));
    });
    
    animate();
}

function placeProfilePics()
{
    $.each(_pics, function(i,v){
        var img = document.createElement("image");
        img.setAttribute("src", v.avatar);
        img.setAttribute("alt", v.name);
        img.setAttribute("title", v.name);
        $("#images").append(img);
    });
    
}

function animate() 
{ 
    for(var i = 1 ; i <= 11; i++)
    {
        for (var j = 0; j < _answersP[i].length; j++)
        {
            var canvas = $(".answer[data-question='"+ i +"']").find("div[data-answer='" + j + "'] canvas").first()[0];
            var context = canvas.getContext('2d');

            // update

            var x = canvas.width / 2;
            var y = canvas.height / 2;
            var radius = 20;
            var percentage = _answersP[i][j]["points"];
            var startAngle = 0 * Math.PI;
            var endAngle = percentage * Math.PI / 50;
            var counterClockwise = false;
            // clear
            context.clearRect(0, 0, canvas.width, canvas.height);

            // draw stuff
            context.translate(canvas.width / 2, canvas.height / 2);
            context.rotate(Math.PI / 200);
            context.translate(-canvas.width / 2, -canvas.height / 2);
            context.beginPath();
            context.lineCap =  'round';
            context.arc(x, y, radius, startAngle, endAngle, counterClockwise);
            context.lineWidth = 8;

            // line color
            context.strokeStyle = '#efccb2';
            context.stroke();
        }
    }
    
    requestAnimFrame(function() {
        animate();
    });
}