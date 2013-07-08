$(document).ready(function() {
	showOverlays();
        
        $('.btn-login').click(function() {
		$('#overlay').clearQueue().fadeIn('fast');
		$('#view-register, #view-disclaimer').clearQueue().hide();
		$('#view-login').clearQueue().delay(100).fadeIn();
	});
//	
	$('.btn-register').click(function() {
		$('#overlay').clearQueue().fadeIn('fast');
		$('#view-login, #view-disclaimer').clearQueue().hide();
		$('#view-register').clearQueue().delay(100).fadeIn();
	});
//	
	$('#view-login .closeBtn, #view-register .closeBtn, #view-disclaimer .closeBtn, #view-forgot .closeBtn').click(function(){
		$('#overlay').clearQueue().fadeOut('fast');
		$('#view-login, #view-register, #view-disclaimer, #view-forgot').clearQueue().delay(100).fadeOut();
		$('#view-login, #view-register, #view-disclaimer, #view-forgot').clearQueue().hide();
	});
	
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
	
	$('footer a, #mobileDisclaimerBtn').click(function() {
		$('#overlay').clearQueue().fadeIn('fast');
		$('#view-login, #view-disclaimer').clearQueue().hide();
		$('#view-disclaimer').clearQueue().delay(100).fadeIn();
	});
	
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