function callTwitch()
{
	var response = $.ajax({
		url: 'https://api.twitch.tv/kraken/streams/?game=League%20of%20Legends',
		async: false,
		dataType: 'JSON',
		headers: {
		'Client-ID': 'bz4bwfixqvekm7bq9n0ebu9rbeds6l'
		}
	}).responseJSON;
	
	return response;
}

function dbTwitch()
{
	var ids = $.ajax({
		url: 'populate.php',
		type: 'POST',
		dataType: 'text',
		data: {'action':'twitch'},
		success: 
	});

	return ids;
}
