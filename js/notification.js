function postAjaxNotif($callback){
	$.ajax({
		async	: true,
		url		: "servers/AjaxServer.php",
		type	: "POST",
		data	: {action: "getNewNotif"}
	}).done(function(a){$callback(a);});
}

function getNewNotif(){
	postAjaxNotif(function(temp){
		temp = JSON.parse(temp);
		
		var html = "";
		var total = 0;
		if(temp.ok){
			var data = temp.data;
			for(var type in data){
				if(type == "feed"){
					var detail = data[type];   // objek feed atau review. bentuk: {1: "nama", 2:"nama"}
					for(var i in detail){
						total++;
						$names = detail[i];
						html += "<div style='float: none; width:250px; margin-bottom: 6px'><div style='width:30px; float:left; margin-top: 5px'><img src='images/notif_feed.png'></div><div style='margin:auto 0px; margin-left: 30px;'><a href='controller.php?dispatch=lihat-feed&id="+i+"'>"+$names+" commented on one of your feeds</a></div></div>";
					}
				}else if(type == "follow"){
					var detail = data[type];   // objek feed atau review. bentuk: {1: "nama", 2:"nama"}
					for(var i in detail){
						total++;
						$names = detail[i];
						html += "<div style='float: none; width:250px; margin-bottom: 6px'><div style='width:30px; float:left; margin-top: 5px'><img src='images/notif_msg.png'></div><div style='margin:auto 0px; margin-left: 30px;'><a href='controller.php?dispatch=lihat-feed&id="+i+"'>"+$names+" commented on a feed you follow.</a></div></div>";
					}
				}else if(type == "review"){
					var detail = data[type];   // objek feed atau review. bentuk: {1: "nama", 2:"nama"}
					for(var i in detail){
						total++;
						$names = detail[i];
						html += "<div style='float: none; width:250px; margin-bottom: 6px'><div style='width:30px; float:left; margin-top: 5px'><img src='images/notif_review.png'></div><div style='margin:auto 0px; margin-left: 30px;'><a href='controller.php?dispatch=info-buku&id="+i+"'>"+$names+" gave review to a book you belong.</a></div></div>";
					}
				}
			}
			if(notifData != html){
				notifData = html;
				$('#notif').fadeOut();
				setTimeout(function(){
					$('#notif').html(html);
					$('#totalNotif').html(total);
					$('#notif').fadeIn();
				}, 500);
			}
		}else{}
	});
}