
function parseURLParams(url)
{
   var queryStart = url.indexOf("?") + 1,
       queryEnd   = url.indexOf("#") + 1 || url.length + 1,
       query = url.slice(queryStart, queryEnd - 1),
       pairs = query.replace(/\+/g, " ").split("&"),
       params = {}, i, n, v, nv;    if (query === url || query === "") return;    for (i = 0; i < pairs.length; i++) {
       nv = pairs[i].split("=", 2);
       n = decodeURIComponent(nv[0]);
       v = decodeURIComponent(nv[1]);        if (!params.hasOwnProperty(n)) params[n] = [];
       params[n].push(nv.length === 2 ? v : null);
   }
   return params;
}

//This function assumes that the url used to reach this page is in the following format:
//http://WEBSITE/WEBPAGE?streamer=NAME
function lookupStreamer()
{
    var params = parseURLParams(window.location.href);
    if(params.hasOwnProperty('streamer'))
    {
	var response = $.ajax({
		url:'stream.php',
                async: false,
                data: {
                'Streamer': params['streamer']
                },	
		success: function(data){
                	console.log(data);
                }
        });
	
	console.log(response);
/*        if()//SQL query is successful
        {
            //Update the page to show the statistics of the streamer
        }
        else //SQL Query fails
        {
            //Update the page to show the streamer could not be found
        }
        //Write the code to run the SQL query and populate the html fields here.*/
    }else
    {
        //Update the page to say that an invalid link was used
    }
}
