
function login($user, $password)
{
	var response = $.ajax({
		url : "auth.php",
		type : "POST",
		data : {"action":"authenticate","user":$user,"password":$password},	
		dataType: "json",
		}).responseJSON;

	console.log(response);
}
