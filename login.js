function loginClick($in_user, $in_pass)
{
	console.log("user is ", $in_user);
	console.log("pass is ", $in_pass);
	
	 var response = $.ajax({
		url : 'rpc_client.php',
		type : 'POST',
		data: {'action': 'authenticate', 'user':$in_user, 'password':$in_pass},
		datatype: "text",
		success: function(data){
			console.log(data);
		}
	});
}
