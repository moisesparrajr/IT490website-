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
 			document.cookie = "id=" + $in_user + ";";
			document.cookie = "jwt=" + data + ";";
			var uc = getCookie("id");
			var jc  = getCookie("jwt");
			console.log(uc);
			console.log(jc);
			location.href = "home.html";
		}
	});
}

function signupClick($in_user, $in_pass, $in_twitch)
{
        console.log("user is ", $in_user);
        console.log("pass is ", $in_pass);
	console.log("twitch ID is", $in_twitch);

        var response = $.ajax({
                url : 'rpc_client.php',
                type : 'POST',
                data: {'action': 'signup', 'user':$in_user, 'password':$in_pass, 'twitchID':$in_twitch},
                datatype: "text",
                success: function(data){
                        document.cookie = "id=" + $in_user + ";";
                        document.cookie = "jwt=" + data + ";";
                        var uc = getCookie("id");
                        var jc  = getCookie("jwt");
                        console.log(uc);
                        console.log(jc);
			alert("Signup successful");
                }
        });
}


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteAllCookies() {
	console.log("deleting cookies");
   	var cookies = document.cookie.split(";");

   	 for (var i = 0; i < cookies.length; i++) {
       		 var cookie = cookies[i];
       		 var eqPos = cookie.indexOf("=");
       		 var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
       		 document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}
