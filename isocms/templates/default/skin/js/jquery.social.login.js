$(function(){
	$('body').delegate('.facebook-signin', 'click', function () {
		$('.alert-success-sign-fb').slideDown(500);
		FB.login(function(response) {
			if (response.authResponse) {	
				facebookToSignIn(response.authResponse.accessToken);
			} else {
				$('.alert-success-sign-fb').hide();
			}
		},{
			scope: 'email'
		});
		return false;
    });

	$('body').delegate('.google-signin', 'click', function (e) {
		var _this = $(this);
		e.preventDefault();
		$('.alert-success-sign-gg').slideDown(500);
		openSignInGoogle();
		return false;
    });
});
function facebookToSignIn(fbAT){
	FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
	function (response) {
		var ajaxURL = "/signinFacebook/" + fbAT;
		$.ajax({
			type:"POST",
			url:ajaxURL,
			data:{
				oauth_provider:'_facebook',
				fbUser:response
			},
			success: function(response){
				$('.close_Ev').trigger('click');
				if(response.indexOf('invalidAccount') >= 0) {
					alert('Email exits');
					//location.href = REQUEST_URI;
					return false;
				}
				if($.trim(return_url) != ''){
					//location.href = return_url;
				}else{
					//location.href = DOMAIN_NAME+extLang;
				}
			}
		});
	});
}

function doLogOut(){
	FB.getLoginStatus(function(response) {
		if (response.status == "connected") {
		}
	});
}

function openSignInGoogle() {
	var win       = window.open(_url, "LoginWithGoogle", 'width=800, height=600'); 
	var pollTimer = window.setInterval(function() { 
		try {
			console.log(win.document.URL);
			if (win.document.URL.indexOf(REDIRECT) != -1) {
				window.clearInterval(pollTimer);
				var url =   win.document.URL;
				acToken =   gup(url, 'access_token');
				tokenType = gup(url, 'token_type');
				expiresIn = gup(url, 'expires_in');
				win.close();
				validateTokenGoogle(acToken);
			}
		} catch(e) {}
	}, 1000);
}

function validateTokenGoogle(token) {
	$.ajax({
		url: VALIDURL + token,
		data: null,
		success: function(responseText){  
			getUserInfoGoogle();
			loggedIn = true;
		},  
		dataType: "jsonp"  
	});
}

function getUserInfoGoogle() {
	$.ajax({
		url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
		data: {},
		success: function(user) {
			var ajaxURL = "/signinGoogle/";
			$("#gbLoading").show();
			$.ajax({
				type:"POST",
				url:ajaxURL,
				data:{
					'id':user.id,
					'email':user.email,
					'full_name':user.name,
					'avatar':user.picture,
					'family_name':user.family_name,
					'given_name':user.given_name,
					'gender':user.gender,
					'verified_email':user.verified_email,
					'hd':user.hd,
					'link':user.link
				},
				success: function(html){
					if(html.indexOf('invalidAccount') >= 0) {
						alert('Email exits');
						return false;
					}else {
						if($.trim(return_url) != ''){
							//location.href = return_url;
						}else{
							//location.href = DOMAIN_NAME+extLang;
						}
							
					}
				}
			});
		},
		dataType: "jsonp"
	});
}

function gup(url, name) {
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\#&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( url );
	if( results == null )
		return "";
	else
		return results[1];
}
function signOut() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		console.log('User signed out.');
	});
}
function checkVaidEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
	return regex.test(email);
}