//function that packs arguments into a JSON
//and sends it via ajax to rpc
//argument[0] MUST BE A TABLE NAME
//all others are columns in a target table

function requestFromDb()
{
	if(arguments.length < 2)
	{
		console.log("Not enough params");
		return;
	}

	var requestJson = {};
	requestJson["table"] = arguments[0];
	for(var i = 1; i < arguments.length; i++)
	{
		requestJson[arguments[i]] = "empty";
	}

	var response = $.ajax({
                url : 'requests_client.php',
                type : 'POST',
                data: {'action': 'request', 'data':JSON.stringify(requestJson)},
		dataType: 'json',
		success: function(result){
			console.log(result)
			return result;
			}
		});

	return response;
}

