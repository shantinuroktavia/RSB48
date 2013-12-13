function countChars(n, textarea, counter) {
	 var maxLength = n;
	 var str = $("#"+textarea).val();
	 var len = str.length;
	 if(len <= maxLength) {
		  $("#"+counter).css("color","#0000ff");
	 } else {
		  $("#"+counter).css("color","#ff0000");
	 }
	  $("#"+counter).html((maxLength-len)+" characters left");
}