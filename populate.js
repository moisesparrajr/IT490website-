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
<<<<<<< HEAD
		type: 'POST',
		dataType: 'text',
		data: {'action':'twitch'},
		success: 
=======
		async: false,
		type: 'POST',
		dataType: 'JSON',
		data: {'action':'twitch'},
>>>>>>> bf5d35123f7b946dbe61ff7c23b8b7e7d0115513
	});

	return ids;
}
