window.fbAsyncInit = function() {
	FB.init({
		appId      : appID,
		status     : true, 
		cookie     : true, 
		xfbml      : true,
		channelUrl: chUrl 
	});
	FB.getLoginStatus(function(response) {
		if (response.status == "connected") {
			console.log('User authorized.');
		}else{
			console.log('User not authorized.');
		}
	}); 
};  
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/vi_VN/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));
$(function(){
	
	$('input[name=agent]').on('click', function() {
		var $_this = $(this);
		if ($_this.is(':checked') == 1 && $_this.val()==2) {
			$('.facebook-up').removeClass('facebook-up').addClass('facebook-signup');
			$('.google-up').removeClass('google-up').addClass('google-signup');
		} else {
			$('.facebook-signup').removeClass('facebook-signup').addClass('facebook-up');
			$('.google-signup').removeClass('google-signup').addClass('google-up');
		}
	});
	$('body').delegate('.facebook-login', 'click', function () {
		FB.login(function(response) {
			if (response.authResponse) {	
				fbToSignIn(response.authResponse.accessToken);
			} else {
				console.log('User cancelled login or did not fully authorize.');
			}
		},{
			scope: 'email'
		});
		return false;
    });
	$('body').delegate('.facebook-up', 'click', function () {
		$('.alert-success-sign-fb').slideDown(500);
		FB.login(function(response) {
			if (response.authResponse) {	
				fbToSignIn(response.authResponse.accessToken);
			} else {
				$('.alert-success-sign-fb').hide();
			}
		},{
			scope: 'email'
		});
		return false;
    });
	$('body').delegate('.facebook-signup', 'click', function () {
		$('.alert-success-sign-fb').slideDown(500);
		FB.login(function(response) {
			if (response.authResponse) {	
				fbToSignIn2(response.authResponse.accessToken);
			} else {
				$('.alert-success-sign-fb').hide();
			}
		},{
			scope: 'email'
		});
		return false;
    });
	$('body').delegate('.google-login', 'click', function (e) {
		var _this = $(this);
		e.preventDefault();
		openSignIn();
		return false;
    });
	$('body').delegate('.google-up', 'click', function (e) {
		var _this = $(this);
		e.preventDefault();
		$('.alert-success-sign-gg').slideDown(500);
		openSignIn();
		return false;
    });
	$('body').delegate('.google-signup', 'click', function (e) {
		var _this = $(this);
		e.preventDefault();
		$('.alert-success-sign-gg').slideDown(500);
		openSignIn2();
		return false;
    });
	$('.zocial').click(function(){
		var $_this = $(this);
		var $_tp = '';
		if($_this.hasClass('facebook')) $_tp = '_FACEBOOK';
		if($_this.hasClass('google')) $_tp = '_GOOGLE';
		if($_this.hasClass('yahoo')) $_tp = '_YAHOO';
		if($_this.hasClass('twitter')) $_tp = '_TWITTER';
		$.ajax({
			url: path_ajax_script+'/index.php?mod=member&act=setTrackingLogin',
			data : {'_tp' : $_tp, '_return_url': _return_url},
			type:"POST",
			success: function(html){
				window.location.href= $_this.attr('href').toString();
			}
		});
		return false;
	});
});
function fbToSignIn(fbAT){
	FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
	function (response) {
		var ajaxURL = "/checkAccountAJAX/" + fbAT;
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
					location.href = REQUEST_URI;
					return false;
				}
				if($.trim(return_url) != '')
					location.href = return_url;
				else
					location.href = DOMAIN_NAME+extLang;
			}
		});
	});
}
function fbToSignIn2(fbAT){
	FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
	function (response) {
		var ajaxURL = "/checkAccountAJAX/" + fbAT;
		$.ajax({
			type:"POST",
			url:ajaxURL,
			data:{
				oauth_provider:'_facebook',
				is_agent:'2',
				fbUser:response
			},
			success: function(response){
				$('.close_Ev').trigger('click');
				if(response.indexOf('invalidAccount') >= 0) {
					alert('Email exits');
					location.href = REQUEST_URI;
					return false;
				}
				if($.trim(return_url) != '')
					location.href = return_url;
				else
					location.href = DOMAIN_NAME+extLang+'/account/agent-signup.html';
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
function Google_SignIn(googleUser) {
	var profile = googleUser.getBasicProfile();
	var ajaxURL = "/checkGoogleAccount/";
	$.ajax({
		url:ajaxURL,
		type:"POST",
		data:{
			'id':profile.getId(),
			'email':profile.getEmail(),
			'full_name':profile.getName(),
			'avatar':profile.getImageUrl(),
			'family_name':profile.getFamilyName(),
			'given_name':profile.getGivenName()
		},
		success: function(response){
			if($.trim(return_url) != '')
				location.href = return_url;
			else
				location.href = DOMAIN_NAME+extLang;
		}
	});
}
function openSignIn() {
	var win         =   window.open(_url, "LoginWithGoogle", 'width=800, height=600'); 
	var pollTimer   =   window.setInterval(function() { 
		try {
			console.log(win.document.URL);
			if (win.document.URL.indexOf(REDIRECT) != -1) {
				window.clearInterval(pollTimer);
				var url =   win.document.URL;
				acToken =   gup(url, 'access_token');
				tokenType = gup(url, 'token_type');
				expiresIn = gup(url, 'expires_in');
				win.close();
				validateToken(acToken);
			}
		} catch(e) {
		}
	}, 1000);
}
function openSignIn2() {
	var win         =   window.open(_url, "LoginWithGoogle", 'width=800, height=600'); 
	var pollTimer   =   window.setInterval(function() { 
		try {
			console.log(win.document.URL);
			if (win.document.URL.indexOf(REDIRECT) != -1) {
				window.clearInterval(pollTimer);
				var url =   win.document.URL;
				acToken =   gup(url, 'access_token');
				tokenType = gup(url, 'token_type');
				expiresIn = gup(url, 'expires_in');
				win.close();
				validateToken2(acToken);
			}
		} catch(e) {
		}
	}, 1000);
}
function validateToken(token) {
	$.ajax({
		url: VALIDURL + token,
		data: null,
		success: function(responseText){  
			getUserInfo();
			loggedIn = true;
		},  
		dataType: "jsonp"  
	});
}
function validateToken2(token) {
	$.ajax({
		url: VALIDURL + token,
		data: null,
		success: function(responseText){  
			getUserInfo2();
			loggedIn = true;
		},  
		dataType: "jsonp"  
	});
}
function getUserInfo() {
	$.ajax({
		url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
		data: {},
		success: function(resp) {
			user    =   resp;
			var ajaxURL = "/checkGoogleAccount/";
			$("#gbLoading").show();
			$.ajax({
				url:ajaxURL,
				type:"POST",
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
						location.href = REQUEST_URI;
						return false;
					}
					if($.trim(return_url) != '')
						location.href = return_url;
					else
						location.href = DOMAIN_NAME+extLang;
					}
			});
		},
		dataType: "jsonp"
	});
}
function getUserInfo2() {
	$.ajax({
		url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + acToken,
		data: {},
		success: function(resp) {
			user    =   resp;
			var ajaxURL = "/checkGoogleAccount/";
			$("#gbLoading").show();
			$.ajax({
				url:ajaxURL,
				type:"POST",
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
					'is_agent':'2',
					'link':user.link
				},
				success: function(html){
					if(html.indexOf('invalidAccount') >= 0) {
						alert('Email exits');
						location.href = REQUEST_URI;
						return false;
					}
					if($.trim(return_url) != '')
						location.href = return_url;
					else
						location.href = DOMAIN_NAME+extLang+'/account/agent-signup.html';
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