/* 
 * ANSWERS.JS
 * 
 * Author Stefaan Christiaens <stefaan.ch@gmail.com>
 * 
 */
var _active = 1;
var _max = 12;

//NAVIGATION
function start(){
    $("#answers-title .row .span12").animate({"margin-left":"-=2000px"}, 1000, function(){
        $(this).parent().parent().hide(function(){
            $("#test").show();
        });
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
        console.log("checking");
        if ($(v).is(':checked')) {
            flag = true;
        }
    });
    return flag;
}

function alertMsg()
{
    var msg =   '<div class="alert fade in span12">'+
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>Hey there!</strong> You can only switch questions if you filled this one in.'+
                '</div>';
    $("#test").append(msg);
    $(".alert").alert();
    setTimeout(function () {
        $(".alert").alert('close')
    }, 3000);
}

function finish()
{
    $("#test").hide();
}


$(document).ready(function(){
    $(".question").each(function(ind,val){
        if ($(val).data('question') === 1) 
            $(val).show();
        else
            $(val).hide();
    });
    $(".previous").addClass("disabled");
});