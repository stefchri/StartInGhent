$(document).ready(function() {
	
	
	$('#list-styles').mouseover(function(){
		$('#list-styles').show();
	});
	
	$('#btn-style').click(function(){
    	$('#list-styles').toggle();
	});
	
	if($('#list-styles:visible')) {
		$('#container, #logo, #content, footer').click(function() {
			$('#list-styles').hide();
		});
	}
	
	$('#nav-mobile .menuBtn').click(function(){
		$('#buttons-header-mobile').clearQueue().fadeToggle('fast');
		$('#overlay').clearQueue().fadeToggle();
	});
	
	if($('#buttons-header-mobile:visible')) {
		$('#container, #content, #logo, #content, footer').click(function() {
			$('#buttons-header-mobile').clearQueue().hide();
		});
	}
	
	$('#view-login a.txtForgot').click(function() {
	//	$('#view-forgot').show();
	});
});

function showOverlays() {
	$('#view-login').show();
	$('#view-forgot').show();
	$('#view-register').show();
        var url = window.location;
        console.log(url.pathname);
        var d = url.pathname.split('');
        var s = url.pathname.split('/');
        if (d [d.length-1] == '/') {
            var pathname = s[s.length-2];
        }else  {
            var pathname = s[s.length-1];
        }
        
	console.log(pathname);
        
        if(pathname == 'login' || pathname == 'forgotpassword' || pathname == 'register')
        {
            $("#overlay").show();
        }
	
}

function showDisclaimer()
{
    $('#overlay').clearQueue().fadeIn('fast');
    $('#view-login, #view-disclaimer').clearQueue().hide();
    $('#view-disclaimer').clearQueue().delay(100).fadeIn();
}