/**
 * @author - Kestutis Matuliauskas
 * @date - 2013.08.12
 * @email - kestutis.itsolutions@gmail.com
 * @description - JSON printer to HTML5 page. Mouse interaction added
 * @version - 1.0
*/
var currID = -1;

// Print the JSON and add mouse interaction to menu links
function printOut (json)
{
	var objParsedJSON = jQuery.parseJSON(json);
	//createDescription$('section.main h2').text(Base64.decode(objParsedJSON[1].title));
	
	totalLength = objParsedJSON.length;
	for(var i = 0; i < totalLength; i++)
	{
		if(i == 0)
		{
			currID = 0;
			createBasicInfo(objParsedJSON[0]);
			createDetails(objParsedJSON[0]);
		}
		$("ul.nav").append('<li><a id="nav-el-' + i + '" href="#">' + Base64.decode(objParsedJSON[i].title) + '</a></li>');
	}
	
	$("ul.nav li a").click(
		function ()
		{
			var newID = $(this).attr('id');
			var newIdParts = newID.split("-");
			newID = newIdParts[newIdParts.length-1];
			console.log(newID);
			if(newID != currID)
			{
				currID = newID;
				createBasicInfo(objParsedJSON[currID]);
				createDetails(objParsedJSON[currID]);
			}
		}
    );
}

// Fill HTML - Section 1
function createBasicInfo (jsonElement)
{
	var title = Base64.decode(jsonElement.title);
	var link = Base64.decode(jsonElement.link);
	var torrent = Base64.decode(jsonElement.torrent);
	var published = Base64.decode(jsonElement.published);
	var author = Base64.decode(jsonElement.author);
	var description = Base64.decode(jsonElement.description);
	
	$('section.main').empty();
	$('section.main').append('<h2>' + title + '</h2>');
	$('section.main').append('<p><strong>Link:</strong> <a href="'+ link +'" target="_blank">' + link.substr(0,50) + '</a></p>');
	$('section.main').append('<p><strong>Download:</strong> <a href="'+ torrent +'" target="_blank">' + torrent + '</a></p>');
	$('section.main').append('<p>Published on <u>' + published + '</u> by <u>' + author + '</u></p>');
	$('section.main').append('<p><strong>Description:</strong> ' + description + '</p>');
}

// Fill HTML - Section 2
function createDetails (jsonElement)
{
	var size = Math.round(parseInt(Base64.decode(jsonElement.size)) / 1024 / 1024);
	var duration = Math.round(parseInt(Base64.decode(jsonElement.duration)) / 60);
	var file_type = Base64.decode(jsonElement.file_type);
	var resolution_w = Base64.decode(jsonElement.resolution_w);
	var resolution_h = Base64.decode(jsonElement.resolution_h);
	var aspect_ratio = Base64.decode(jsonElement.aspect_ratio);
	
	$('section.secondary').empty();
	$('section.secondary').append('<h2>Details</h2>');
	$('section.secondary').append('<p><strong>Size:</strong> ' + size + ' MB</p>');
	$('section.secondary').append('<p><strong>Duration:</strong> ' + duration + ' min</p>');
	$('section.secondary').append('<p><strong>Type:</strong> ' + file_type + '</p>');
	$('section.secondary').append('<p><strong>Resolution:</strong> ' + resolution_w + ' x ' + resolution_h + ' (' + aspect_ratio + ')</p>');
}