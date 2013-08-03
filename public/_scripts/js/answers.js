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
    if (_active !== _max) 
    {
        showAnswer(++_active, true);
        if (_active === _max)
           $(".next").addClass("disabled"); 
       else
           $(".previous").removeClass("disabled"); 
    }
    else
    {
        $(".next").addClass("disabled");
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
            $(".next").removeClass("disabled"); 
    }
    else
    {
        $(".previous").addClass("disabled");
    }
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