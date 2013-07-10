// JavaScript Document
var json_content = { "p_text": "Dates:",
                     "button_text": "Display dates"};
                     
var json_date_content = { "day1": "5/1/2011",
                          "day2": "5/2/2011",
                          "day3": "5/3/2011",
                          "day4": "5/4/2011",
                          "day5": "5/5/2011",
                          "day6": "5/6/2011",
                          "day7": "5/7/2011"};
						 
function loadExtraContent()
{
	var createDateButton = document.getElementsByTagName('button')[0];
	var showDateButton = document.getElementsByTagName('button')[1];
	var allDivs = document.getElementsByTagName('div');
	var firstDiv = allDivs[0];
	var totalDivs = allDivs.length;
	
	// When I click 'Create dates header':
	createDateButton.onmousedown = function()
	{
		// The 'Create dates header' button should not be displayed
		createDateButton.className = "no_display";
		
		// I should see a 'Display dates' button
		showDateButton.className = "";
		showDateButton.innerHTML = json_content.button_text;
		
		// I should see some new text 'Dates:'
		var newTextElement = document.createElement('<p class="dates">'+ json_content.p_text +'</p>');
		document.all.newTextElement.insertBefore(firstDiv);
	}
	
	// When I click the 'Display dates' button:
	showDateButton.onmousedown = function()
	{
		// I should see the dates '5/1/2011' through '5/7/2011'
		for(var i=0; i<totalDivs; i++)
		{
			// Get current div
			var elem = allDivs[i];
			
			// Get content o Json element
			var jsonElemName = 'json_date_content.day' + (i+1);
			var innerElemContent = eval(jsonElemName);
			
			//  added to the empty divs
			if(elem.innerHTML == '')
			{
				// The dates should be displayed in red
				elem.className = 'red_text';
				var jsonElemName = 'json_date_content.day' + (i+1);
				elem.innerHTML = innerElemContent;
			} else
			{
				// Create a new div if it is not an empty div element
				var newTextElement = document.createElement('<div class="red_text">'+ innerElemContent +'</div>');
				document.all.newTextElement.insertBefore(elem);
			}
		}
	}
}