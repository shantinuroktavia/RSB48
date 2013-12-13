function getTotalNewMessages(obj){
	var $obj = $(obj);
	$.ajax({
		async	: true,
		data	: {action: "getNewMessages"},
		url		: "servers/AjaxServer.php",
		type	: "POST"	
	}).done(function(a){$obj.html("("+JSON.parse(a).total+")")});
}

function sendAjaxRequest(obj){
	$data = obj.data;
	$callback = obj.callback;
	$.ajax({
		async	: true,
		data	: $data,
		url		: "servers/AjaxServer.php",
		type	: "POST"		
	}).done(function(a){$callback(a);});
}
/************* Lightbox Code Source *******************/
/* source: http://www.emanueleferonato.com/2007/08/22/create-a-lightbox-effect-only-with-css-no-javascript-needed/ */	

function showComplaintBox() {
	document.getElementById('light').style.display = 'block';
	document.getElementById('fade').style.display = 'block';
}

function closeLightBox() {
	document.getElementById('light').style.display = 'none';
	document.getElementById('fade').style.display = 'none';
}

function closeLightBoxDel() {
	document.getElementById('light_delete').style.display = 'none';
	document.getElementById('fade').style.display = 'none';
}

function closeConfirmationBox() {
	document.getElementById('confirmation').style.display = 'none';
	document.getElementById('fade').style.display = 'none';

}

function showComment(id) {
	document.getElementById(id).style.display = 'block';
	//document.getElementById('comm_show').style.display = 'none';
}

function closeComment(id) {
	document.getElementById(id).style.display = 'none';
}