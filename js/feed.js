$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Nopember", "December"];

function stripTags(html){
	var div = document.createElement("div");
	div.innerHTML = html;
	return div.textContent || div.innerText || "";
}

function addSlashes(text){
	return text.replace(/\"/g, "\\\"").replace(/\'/g, "\\\'");
}

function postFeed($obj){
	//console.log($obj);
	$type = $obj.type;
	$location_id = $obj.location_id;
	switch($type){
		case 0: // pertanyaan
			$content = $obj.content;
			$callback = $obj.callback;
			$data = {'content':$content, action:'postFeed', 'location_id':$location_id};
			postFeedAjax($data, $callback);
		break;
		case 1: // komentar
			$parent = $obj.parent;
			$content = $obj.content;
			$callback = $obj.callback;
			$data = {'content':$content, 'parent':$parent, action:'postComment'};
			postFeedAjax($data, $callback);
		break;
	}
}

function checkNewFeeds($data){
	$callback = $data.callback;
	$location_id = $data.location_id;
	$data = {'timestamp':$timestamp, action:'checkNewFeeds', 'location_id':$location_id};
	postFeedAjax($data, $callback);
}

function getNewFeeds($data){
	$callback = $data.callback;
	$location_id = $data.location_id;
	$data = {'timestamp':$timestamp, action:'getNewFeeds', 'location_id':$location_id};
	postFeedAjax($data, $callback);
	$timestamp = Math.round(new Date().getTime() / 1000);
}

function getFeeds($data){
	console.log($data);
	console.log($lasttimestamp);
	$callback = $data.callback;
	$total = $data.total;
	$location_id = $data.location_id;
	$data = {'timestamp':$lasttimestamp, action:'getFeeds', 'total':$total, 'location_id':$location_id};
	postFeedAjax($data, $callback);
}

function displayFeed($data, $keys, $before){  // jika $before==true, feed diletakkan dipaling atas, sebaliknya dipaling bawah
	$feed = "";
	for($i=0; $i<$keys.length; $i++){
		$obj = $data[$keys[$i]];
		$imageUrl = $obj.poster_url;
		$posterName = $obj.poster_name;
		$posterUsername = $obj.poster_username;
		$time = $obj.time;
		$content = stripTags($obj.content);
		$unformatted_time = $obj.unformatted_time;		
		$class_name = "comm_"+$keys[$i]+"_box";
		
		$commentaries = $($obj.commentaries);
		$n = $commentaries.length;
		
		$feed += "<div class='feed' style='display:none'><div class='4u'><div class='thumbnail'><a href='controller.php?dispatch=lihat-profil&user="+$posterUsername+"'><img src='"+$imageUrl+"' alt='' width='46' height='61'/></a><cite><strong><a href='controller.php?dispatch=lihat-profil&user="+$posterUsername+"'>"+$posterName+"</a></strong>"+$time+" says:</cite><blockquote>"+$content+"</blockquote></div><div class='link_bar'>&nbsp;&nbsp;&nbsp;"+getTwitterButton($posterName+" says: "+$content)+"<div style='font-size:12px; color:#45d; margin-top:-10px' id='fb"+$keys[$i]+"'></div><a href='javascript:void(0)' onclick='showComment(\"comm_box"+$keys[$i]+"\")' class='comm_close' style='float:right; padding-right:20px'>See Comment ("+$n+")</a></div><div id='notif"+$keys[$i]+"' style='display: hidden'></div> <br /><div class='comm_box' id='comm_box"+$keys[$i]+"' style='display:none; margin-left:20px'><div class='comm_other'><table>";
				
		for($j=0; $j<$n; $j++){	
			$temp_name = $commentaries[$j].poster_name;
			$temp_url = $commentaries[$j].poster_url;
			$temp_userName = $commentaries[$j].poster_username;
			$temp_content = stripTags($commentaries[$j].content);
			$temp_time = $commentaries[$j].time;
			$feed += "<tr class='"+$class_name+" comment'><td class='comm un' style='font-size:15px; font-weight:bolder'><img src='"+$temp_url+"' alt='' width='46' height='61'/> </td><td class='comm ctn' style='line-height:16px; padding:4px'><a href='controller.php?dispatch=lihat-profil&user="+$temp_userName+"' style='color:#78b9b9; font-weight:bolder'>"+$temp_name+"</a><span style='float:right'>"+$temp_time+"</span><br/> <div class='comment_content'>"+$temp_content+"</div></td></tr>";
		}
		if($j === 0){
			$feed +="<tr class='"+$class_name+"'></tr>";
		}
		if(typeof $global_username != "undefined" && typeof $global_url != "undefined" && typeof $global_name != "undefined"){
			$feed += "</table></div><div class='comment_reply'><div style='margin-right:4px'><textarea placeholder='Type your answer/comment here.' id='comment"+$keys[$i]+"'></textarea></div><div class='comment_button'><a href='javascript:void(0)' onclick='closeComment(\"comm_box"+$keys[$i]+"\")' class='comm_close'>Close Comment</a><span style='margin-right:5px; height:40px'><a href='javascript:void(0)' onclick='postComment({content: $(\"#comment"+$keys[$i]+"\").val(), parent:"+$keys[$i]+"})' class='comm_close'>Post Comment</a></span></div></div></div></div><div class='row'><div class='divider'></div></div>";
		}else{
			$feed += "</table></div><div class='comment_reply'><div class='comment_button' style='margin-top:0px'><a href='javascript:void(0)' onclick='closeComment(\"comm_box"+$keys[$i]+"\")' class='comm_close'>Close Comment</a></div></div></div></div><div class='row'><div class='divider'></div></div>";
		}
		if($i == $keys.length - 1 && !$before){
			$lasttimestamp = Math.round(new Date($unformatted_time).getTime() / 1000);
		}
	}
	if($before)
		$(".feed").first().before($feed);
	else
		$(".feed").last().after($feed);
	setTimeout(function(){$(".feed").each(function(i, obj){$(obj).fadeIn();});}, 1000);
}

function postComment($data){
	console.log($data);
	$content = stripTags($data.content);
	$parent = $data.parent;
	$class_name = "comm_"+$parent+"_box";
	$poster_username = $global_username;
	$poster_name = $global_name;
	$poster_url = $global_url;
	$now = new Date();
	$time = $months[$now.getMonth()]+" "+($now.getDate()<10?"0"+$now.getDate():$now.getDate())+", "+$now.getFullYear()+" "+($now.getHours()<10?"0"+$now.getHours():$now.getHours())+":"+($now.getMinutes()<10?"0"+$now.getMinutes():$now.getMinutes());
	
	postFeed({
		type:1, 
		content:$content, 
		parent:$parent,  
		callback: function(data){
			$obj = JSON.parse(data);
			if($obj.ok){
				$("#comment"+$parent).val('');
				$("."+$class_name).last().after(
					"<tr class='"+$class_name+" comment' style='display:none'><td class='comm un' style='font-size:15px; font-weight:bolder'><img src='"+$poster_url+"' alt='' width='46' height='61'/> </td><td class='comm ctn' style='line-height:16px; padding:4px'><a href='controller.php?dispatch=lihat-profil&user="+$poster_username+"' style='color:#78b9b9; font-weight:bolder'>"+$poster_name+"</a><span style='float:right'>"+$time+"</span><br/> <span class='comment_content'>"+$content+"</span></td></tr> ");
				setTimeout(function(){$("."+$class_name).last().fadeIn();}, 1000);
				$("#comment"+$parent).focus();
			}else{
				$("."+$class_name).last().after(
					"<tr class='"+$class_name+" comment_error'><td class='comm un' style='font-size:15px; font-weight:bolder'></td><td class='comm ctn' style='line-height:16px; padding:4px'><span style='float:right'>"+$time+"</span><br/> <span style='text-align:justify; color:#700'>Failed. Reason: "+$obj.message+"</span></td></tr> ");
					
				setTimeout(function(){$(".comment_error").each(function(i, obj){$(obj).fadeOut();});}, 2000);
			}
		}	
	});
}

function postSingleComment($data){
	console.log($data);
	$content = stripTags($data.content);
	$parent = $data.parent;
	$class_name = "comm_"+$parent+"_box";
	$poster_username = $global_username;
	$poster_name = $global_name;
	$poster_url = $global_url;
	$now = new Date();
	$time = $months[$now.getMonth()]+" "+($now.getDate()<10?"0"+$now.getDate():$now.getDate())+", "+$now.getFullYear()+" "+($now.getHours()<10?"0"+$now.getHours():$now.getHours())+":"+($now.getMinutes()<10?"0"+$now.getMinutes():$now.getMinutes());
	
	postFeed({
		type:1, 
		content:$content, 
		parent:$parent,  
		callback: function(data){
			$obj = JSON.parse(data);
			if($obj.ok){
				$("#comment"+$parent).val('');
				$("."+$class_name).last().after(
					"<tr class='"+$class_name+"'><td width='680'><div width='680' style='background-color: #eee; padding: 5px;  height:90px;'><div style='width:60px; float:left;'><img src='"+$poster_url+"' width='30px' height='40px' /><div style='font-size:12px; line-height:20px'>"+$time+"</div></div><div style='font-size:14px; float:right; width: 580px;'><a href='controller.php?dispatch=lihat-profil&user="+$poster_username+"'>"+$poster_name+"</a>:"+$content+"</div></div></td></tr>");
					//"<tr class='"+$class_name+" comment' style='display:none'><td class='comm un' style='font-size:15px; font-weight:bolder'><img src='"+$poster_url+"' alt='' width='46' height='61'/> </td><td class='comm ctn' style='line-height:16px; padding:4px'><a href='controller.php?dispatch=lihat-profil&user="+$poster_username+"' style='color:#78b9b9; font-weight:bolder'>"+$poster_name+"</a><span style='float:right'>"+$time+"</span><br/> <span class='comment_content'>"+$content+"</span></td></tr> ");
				setTimeout(function(){$("."+$class_name).last().fadeIn();}, 1000);
				$("#comment"+$parent).focus();
			}else{
				$("."+$class_name).last().after(
					"<tr class='"+$class_name+" comment_error'><td width='680'><div width='680' style='background-color: #eee; padding: 5px;  height:90px;'><div style='width:60px; float:left;'></div><div style='font-size:14px; float:right; width: 580px;'>Failed. Reason: "+$obj.message+"</div></div></td></tr>");
					
				setTimeout(function(){$(".comment_error").each(function(i, obj){$(obj).fadeOut();});}, 2000);
			}
		}	
	});
}

function postFeedAjax($data, $callback){
	$.ajax({
		async	: true,
		data	: $data,
		url		: "servers/AjaxServer.php",
		type	: "POST"		
	}).done(function(a){$callback(a);});
}

function getTwitterButton($content){
	console.log($content.replace(/\'/g, "\""));
	$encoded = encodeURIComponent($content.replace(/\'/g, "\""));
	$data = "<a class=\"tw\" href=\"javascript:void(0)\" onclick=\"window.open('https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Fbuku-kuliah.com%2Fbetalive%2Fview.php%3Fp%3Dhalaman-utama.tpt&text="+$encoded+"&tw_p=tweetbutton&via=Buku_Kuliah', 'Tweet this feed', 'width=500,height=400')\" ><img src='images/tw_share.png' alt='' width='100' height='30'/></a>";								
	return $data;
}