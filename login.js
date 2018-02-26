function loginClick($in_user, $in_pass)
{
	console.log("user is ", $in_user);
	console.log("pass is ", $in_pass);
	
	 var response = $.ajax({
		url : 'send.php',
		type : 'POST',
		data: {'action': 'authenticate', 'user':'theuser', 'password':'thepassword'},
		datatype: "json",
	});
	
	console.log(response);
}