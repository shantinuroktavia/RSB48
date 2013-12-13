function fb_init(){	
	FB.init({
		appId : '629998197016085',
		status : true,
		cookie : true,
		xfbml : true
	});
}

function login(f, data){
	FB.login(
		function(response) {
			if (response.authResponse) {
				console.log('Welcome!  Fetching your information.... ');
				FB.api('/me', function(response) {
					console.log('Good to see you, ' + response.name + '.');
				});
				f(data);
			} else {
				console.log('User cancelled login or did not fully authorize.'); 
			}
		},{ scope: 'publish_actions' }
	);
}


function fb_post(data) {
	$("#fb"+data.parent).html("processing...");
	$("#fb"+data.parent).fadeOut();
	
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			var publish = {
				method: 'stream.publish',
				redirect_uri: 'http://buku-kuliah.com/betalive/', 
				link: data.url,
				picture: "http://buku-kuliah.com/betalive/images/logo2.jpg",
				name: data.title,
				caption: data.caption,
				description: data.description,
				actions : { name : 'Buku-Kuliah.com', link : 'http://buku-kuliah.com'}
			};
	
			FB.api('/me/feed', 'POST', publish, function(response) {  
				if (response) {
					$("#fb"+data.parent).html("Success posting to FB");
				}else {
					$("#fb"+data.parent).html("Failed posting to FB");
				}
				$("#fb"+data.parent).fadeOut();
				setTimeout(function(){
					$("#fb"+data.parent).fadeIn();
				}, 3000);
			});
		}else{
		  login(fb_post, data); 
		} 
	});
}

function fb_publish(data) {
	$("#fb"+data.parent).html("processing...");
	$("#fb"+data.parent).fadeOut();
	
	FB.getLoginStatus(function(response) {
		if (response.status === 'connected') {
			var publish = {
				method: 'feed',
				link: data.url,
				picture: "http://buku-kuliah.com/betalive/images/logo2.jpg",
				name: data.title,
				caption: data.caption,
				description: data.description,
				actions : { name : 'Buku-Kuliah.com', link : 'http://buku-kuliah.com'}
			};
			FB.ui(publish, function(response) {  
					if (response) {
						$("#fb"+data.parent).html("Success posting to FB");
					}else {
						$("#fb"+data.parent).html("Failed posting to FB");
					}
					$("#fb"+data.parent).fadeOut();
					setTimeout(function(){
						$("#fb"+data.parent).fadeIn();
					}, 3000);
				});
		}else{
		  login(fb_publish, data); 
		} 
	});
}