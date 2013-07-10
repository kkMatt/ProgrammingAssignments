// Run the code when the DOM is ready
$( pieChart );

function pieChart() {
	var debug = 0;  // True or false, firebug console based debug
	
  // Config settings
  var chartSizePercent = 50;                        // The chart radius relative to the canvas width/height (in percent)
  var sliceBorderWidth = 2;                         // Width (in pixels) of the border around each slice
  var sliceBorderStyle = "#fff";                    // Colour of the border around each slice
  var sliceGradientColour = "#ddd";                 // Colour to use for one end of the chart gradient
  var pullOutBounceStep = 5;
  var bounceTimes = 3;
  var minPullOutDistance = 20;
  var maxPullOutDistance = 45;         // DEF 25    // How far, in pixels, to pull slices out when clicked
  var pullOutFrameStep = 4;            // DEF: 4    // How many pixels to move a slice with each animation frame
  var pullOutFrameInterval = 20;       // DEF:40    // How long (in ms) between each animation frame
  var pullOutLabelPadding = 55;                     // Padding between pulled-out slice and its label  
  var pullOutLabelFont = "bold 16px 'Trebuchet MS', Verdana, sans-serif";  // Pull-out slice label font
  var pullOutValueFont = "bold 12px 'Trebuchet MS', Verdana, sans-serif";  // Pull-out slice value font
  var pullOutValuePrefix = "$";                     // Pull-out slice value prefix
  var pullOutShadowColour = "rgba( 0, 0, 0, .5 )";  // Colour to use for the pull-out slice shadow
  var pullOutShadowOffsetX = 5;                     // X-offset (in pixels) of the pull-out slice shadow
  var pullOutShadowOffsetY = 5;                     // Y-offset (in pixels) of the pull-out slice shadow
  var pullOutShadowBlur = 5;                        // How much to blur the pull-out slice shadow
  var pullOutBorderWidth = 2;                       // Width (in pixels) of the pull-out slice border
  var pullOutBorderStyle = "#333";                  // Colour of the pull-out slice border
  var chartStartAngle = -.5 * Math.PI;              // Start the chart at 12 o'clock instead of 3 o'clock

  // Declare some variables for the chart
  var canvas;                       // The canvas element in the page
  var currentPullOutSlice = -1;     // The slice currently pulled out (-1 = no slice)
  var currentPullOutDistance = 0;   // How many pixels the pulled-out slice is currently pulled out in the animation
  var currentBounceTimes = 0;
  var currentMinPullOutDistance = 0;
  var currentMaxPullOutDistance = 0;
  var animationId = 0;              // Tracks the interval ID for the animation created by setInterval()

  var pieStartupDrawingInterval = 6;
  var drawnAnimationPercentageIncrementStep = 2; // 100 perc total, so 20 steps
  var currSlice = 0;
  var totalSlices = 0;
  var currentDrawnAnimationPercentage = 0;
  var introAnimationId = 0;          // Tracks the interval ID for the animation created by setInterval()
  var chartData = [];               // Chart data (labels, values, and angles)
  var chartColours = [];            // Chart colours (pulled from the HTML table)
  var totalValue = 0;               // Total of all the values in the chart
  var canvasWidth;                  // Width of the canvas, in pixels
  var canvasHeight;                 // Height of the canvas, in pixels
  var centreX;                      // X-coordinate of centre of the canvas/chart
  var centreY;                      // Y-coordinate of centre of the canvas/chart
  var chartRadius;                  // Radius of the pie chart, in pixels
  
  var pieChartDrawingIsFinished = false;
  var currentDepth = 1;
  
  // Set things up and draw the chart
  init();


  /**
   * Set up the chart data and colours, as well as the chart and table click handlers,
   * and draw the initial pie chart
   */

  function init() {

    // Get the canvas element in the page
    canvas = document.getElementById('chart');

    // Exit if the browser isn't canvas-capable
    if ( typeof canvas.getContext === 'undefined' ) return;

    // Initialise some properties of the canvas and chart
    canvasWidth = canvas.width;
    canvasHeight = canvas.height;
    centreX = canvasWidth / 2;
    centreY = canvasHeight / 2;
    chartRadius = Math.min( canvasWidth, canvasHeight ) / 2 * ( chartSizePercent / 100 );
	
	/*
	// listen pie chart tr clicks
	var totalOpenGroups = $('#chartData tr').each( function() {
		$(this).click( handle);
		var currentTrClass = $(this).attr('class');
		if(currentTrClass == "group_expanded")
		{
			
		}
	});
	*/
	
	// Manage current pie
	assignTableToPieChart();
	
	$('#chartData tr.group_expanded,#chartData tr.group_collapsed').click( handleTableGroupClick );
  }
  
  
  /**
   * Process mouse clicks in the table area.
   *
   * Retrieve the slice number from the jQuery data stored in the
   * clicked table cell, then toggle the slice
   *
   * @param Event The click event
   */

  function handleTableGroupClick ( clickEvent )
  {
		var clickedTrClass = $(this).attr('class');
		var clickedTrLabel = $(this).children('td:nth-child(3)').text();
		var clickedObj = $(this);
		updateTableAfterTableGroupOrPieChartClick ( clickedObj, clickedTrClass, clickedTrLabel );
  }
  
  
  function handleChartClickWhenGroupsLevel ( slice )
  {
	    if(slice != -1)
		{
			var clickedTrClass = "group_collapsed";
			var clickedTrLabel = $('#chartData tr.group_collapsed:eq(' + slice + ') td:nth-child(3)').text();
			var clickedObj = $('#chartData tr.group_collapsed:eq(' + slice + ')');
		} else
		{
			var clickedTrClass = "group_expanded";
			var clickedTrLabel = 'undefined';
			var clickedObj = null;
		}
		if(debug) console.log('Chart click &#39;handleChartClickWhenGroupsLevel&#39;, Slice: ' + slice + ', label: ' + clickedTrLabel);
		updateTableAfterTableGroupOrPieChartClick ( clickedObj, clickedTrClass, clickedTrLabel );
  }
  
  function updateTableAfterTableGroupOrPieChartClick ( clickedObj, clickedTrClass, clickedTrLabel )
  {
	  	var currentTrLabelFound = false;
	    var changeAllNextChildsTo = "closed";
		var debugCase = -1;
		
		if(clickedTrClass.indexOf('group_expanded') !== -1)
		{
			debugCase = 101;
			// Close group
			if(clickedObj != null)
			{
				clickedObj.attr('class', 'group_collapsed');
			}
			globalChangeAllNextChildsTo = "closed";
		} else if(clickedTrClass.indexOf('group_collapsed') !== -1)
		{
			debugCase = 102;
			// Open group
			if(clickedObj != null)
			{
				clickedObj.attr('class', 'group_expanded');
			}
			globalChangeAllNextChildsTo = "open";
		}
		// Local setter 
		var localChangeAllNextChildsTo = globalChangeAllNextChildsTo;		
		
		/***DEBUG***/ if(debug)
		/***DEBUG***/ {
	  	/***DEBUG***/ 	console.log('click handleTableGroupClick, clickedTrClass:' + clickedTrClass +
							' clickedTrLabel:' + clickedTrLabel + ' [ cANCT Set: ' + globalChangeAllNextChildsTo  + ' ],  <Case: '+debugCase+'>');
		/***DEBUG***/ }
	  
	  $('#chartData tr.group_expanded,#chartData tr.group_collapsed,#chartData tr.element_expanded,#chartData tr.element_collapsed').each(function() {
		var currentTrClass = $(this).attr('class');
		var currentTrLabel = $(this).children('td:nth-child(3)').text();
		
		debugCase = 0;
		if(currentTrClass.indexOf('group_expanded') !== -1 || currentTrClass.indexOf('group_collapsed') !== -1)
		{
			// Workaround, or maybe not
			if(globalChangeAllNextChildsTo == "closed")
			{
				debugCase = 10;
				$(this).attr('class', 'group_collapsed');
				localChangeAllNextChildsTo = "closed";
			} else
			{
				// Clicked group label is equals to current title
				if (clickedTrLabel != currentTrLabel)
				{
					debugCase = 11;
					$(this).attr('class', 'group_collapsed');
					localChangeAllNextChildsTo = "closed";
				} else
				{
					debugCase = 12;
					currentTrLabelFound = true;
					localChangeAllNextChildsTo = "open";
				}
			}
		} else if(currentTrClass.indexOf('element_expanded') !== -1 || currentTrClass.indexOf('element_collapsed') !== -1)
		{
			debugCase = 20;
			if(localChangeAllNextChildsTo == "open")
			{
				debugCase = 21;
				$(this).attr('class', 'element_expanded');
			} else if(localChangeAllNextChildsTo == "closed")
			{
				debugCase = 22;
				$(this).attr('class', 'element_collapsed');
			}
		}
		/***DEBUG***/ if(debug)
		/***DEBUG***/ {
		/***DEBUG***/ 	console.log('current tr class: '+ currentTrClass + ' --> ' + $(this).attr('class') + ' [ cANCT: ' + localChangeAllNextChildsTo  + ' ]  <Case: '+debugCase+'>, curr label: ' + currentTrLabel);
		/***DEBUG***/ }
	  });
	  // Manage current pie
	  assignTableToPieChart();
  }  
  
  
  function assignTableToPieChart()
  {
	// Reset
	currSlice = 0;
	currentPullOutSlice = -1;
	currentPullOutDistance = 0;
	currentBounceTimes = 0;
	currentDrawnAnimationPercentage = 0;
	totalValue = 0;
	chartData = [];
	chartColours = [];
	pieChartDrawingIsFinished = false; // Restart note
	
	// Kill any bounce or any other working visual effect
	clearInterval( introAnimationId );
	clearInterval( animationId );
	  
	  
	// Check if is there any categories open
	var totalOpenGroups = $('#chartData tr.group_expanded').size();

	var selector = "";

	// If no groups open
	if(totalOpenGroups == 0)
	{
		// create a pie chart data from group titles
		selector = "#chartData tr.group_collapsed td";
		currentDepth = 1;
	} else
	{
		// chreate a pie chart data frpm group elements
		selector = "#chartData tr.element_expanded td";
		currentDepth = 2;
	}

    // Grab the data from the table,
    // and assign click handlers to the table data cells
	
    var currentRow = 0;
    var currentCell = 0;
	
	var currentColor = "#000000";

	/***DEBUG***/ if(debug)
	/***DEBUG***/ {
	/***DEBUG***/ 	console.log('<ass.T.ToPieChart> Selector: [[' + selector + ']], totalOpenGroups: ' + totalOpenGroups);
	/***DEBUG***/ }

    $(selector).each( function() {
		currentCell++;

		if ( currentCell == 1 ) {
			chartData[currentRow] = [];
		} else if ( currentCell == 2 ) {
			// Define color
			currentColor = $(this).children('div').css('background-color');
			
			// If there is an error
			if(currentColor === undefined)
			{
				// Use black
				currentColor = "#000000";
			}
			
			/***DEBUG***/ if(debug >= 2)
			/***DEBUG***/ {
			/***DEBUG***/   console.log('TD #2: ' + $(this).html() + ' Extracted color: + ' + currentColor);
			/***DEBUG***/ }
			
			
			// Extract and store the cell colour
			if ( rgb = currentColor.match( /rgb\((\d+), (\d+), (\d+)/) ) {
				chartColours[currentRow] = [ rgb[1], rgb[2], rgb[3] ];
			} else if ( hex = currentColor.match(/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/) ) {
				chartColours[currentRow] = [ parseInt(hex[1],16) ,parseInt(hex[2],16), parseInt(hex[3], 16) ];
			} else {
				alert( "Error: Colour could not be determined! Please specify table colours using the format '#xxxxxx'" );
				return;
			}
			
		} else if ( currentCell == 3 ) {
			// Define label
			chartData[currentRow]['label'] = $(this).text();
		} else if ( currentCell == 5 ) {
			// Define value
			var value = parseFloat($(this).text());
			totalValue += value;
			value = value.toFixed(2);
			chartData[currentRow]['value'] = value;
		} else if ( currentCell == 6 ) {
			// Next line
			currentRow++;
			currentCell = 0;
		}

      // Store the slice index in this cell, and attach a click handler to it
      $(this).data( 'slice', currentRow );
	  // Store current depth
	  $(this).data( 'depthInTable', currentDepth );
	  $(this).hover(
	    handleTableMouseOver,
		function () {
			// Do nothing
    		//$(this).append($("<span> ***</span>"));
  		}
	  );
	  
	  // Open group click handler
	  // If no groups open
	  if(totalOpenGroups != 0)
	  {
	        $(this).click( handleTableOpenGroupTdElementClick );
			// Other table clicks are managed by different function bellow
	  }
    } );

    // Now compute and store the start and end angles of each slice in the chart data

    var currentPos = 0; // The current position of the slice in the pie (from 0 to 1)

    for ( var slice in chartData ) {
      chartData[slice]['startAngle'] = 2 * Math.PI * currentPos;
      chartData[slice]['endAngle'] = 2 * Math.PI * ( currentPos + ( chartData[slice]['value'] / totalValue ) );
      currentPos += chartData[slice]['value'] / totalValue;
    }

    // All ready! Now draw the pie chart, and add the click handler to it
    drawChartWithIntro();
	// click changed to hover
    $('#chart').hover(
		processMouse,
		function () {
			// Do nothing
    		//$(this).append($("<span> ***</span>"));
  		}
 	);
	
	
	// Handle clicks [outside area]
	$('#chart').click( handleChartClick );
  }
  
  function processMouse ( clickEvent )
  {
	  $('#chart').mousemove( handleChartMouseOver );
  }

  /**
   * Process mouse clicks in the chart area.
   *
   * If a slice was clicked, toggle it in or out.
   * If the user clicked outside the pie, push any slices back in.
   *
   * @param Event The click event
   */

  function handleChartMouseOver ( clickEvent ) {
	  // If the pie chart is already drawn - 100 perc. or eq
	  if(pieChartDrawingIsFinished)
	  {
		// Get the mouse cursor position at the time of the click, relative to the canvas
		var mouseX = clickEvent.pageX - this.offsetLeft;
		var mouseY = clickEvent.pageY - this.offsetTop;
	
		// Was the click inside the pie chart?
		var xFromCentre = mouseX - centreX;
		var yFromCentre = mouseY - centreY;
		var distanceFromCentre = Math.sqrt( Math.pow( Math.abs( xFromCentre ), 2 ) + Math.pow( Math.abs( yFromCentre ), 2 ) );
	
		if ( distanceFromCentre <= chartRadius ) {
			
			  ///console.log ("[INSIDE] mouseX:" + mouseX + " mouseY:" + mouseY);
			  // Yes, the click was inside the chart.
			  // Find the slice that was clicked by comparing angles relative to the chart centre.
			
			  var clickAngle = Math.atan2( yFromCentre, xFromCentre ) - chartStartAngle;
			  if ( clickAngle < 0 ) clickAngle = 2 * Math.PI + clickAngle;
						  
			  for ( var slice in chartData ) {
				if ( clickAngle >= chartData[slice]['startAngle'] && clickAngle <= chartData[slice]['endAngle'] ) {
			
				  // Slice found. Pull it out or push it in, as required.
				  toggleSlice ( slice );
				  return;
				}
			  }
		}
	
		// User must have clicked outside the pie. Push any pulled-out slice back in.
		// pushIn();
	  }
  }


  /**
   * Process mouse clicks in the chart area.
   *
   * If a slice was clicked, toggle it in or out.
   * If the user clicked outside the pie, push any slices back in.
   *
   * @param Event The click event
   */

  function handleChartClick ( clickEvent ) {

    // Get the mouse cursor position at the time of the click, relative to the canvas
    var mouseX = clickEvent.pageX - this.offsetLeft;
    var mouseY = clickEvent.pageY - this.offsetTop;

    // Was the click inside the pie chart?
    var xFromCentre = mouseX - centreX;
    var yFromCentre = mouseY - centreY;
    var distanceFromCentre = Math.sqrt( Math.pow( Math.abs( xFromCentre ), 2 ) + Math.pow( Math.abs( yFromCentre ), 2 ) );

    if ( distanceFromCentre <= chartRadius ) {

      // Yes, the click was inside the chart.
      // Find the slice that was clicked by comparing angles relative to the chart centre.

      var clickAngle = Math.atan2( yFromCentre, xFromCentre ) - chartStartAngle;
      if ( clickAngle < 0 ) clickAngle = 2 * Math.PI + clickAngle;
                  
      for ( var slice in chartData ) {
        if ( clickAngle >= chartData[slice]['startAngle'] && clickAngle <= chartData[slice]['endAngle'] ) {
			// Slice found
			if(currentDepth == 2)
			{
				 // If the pie chart is already drawn - 100 perc. or eq
				if(pieChartDrawingIsFinished)
				{
					// Element list - pull slice out or push it in, as required.
          			toggleSliceOnChartClick ( slice );
				}
			} else if(currentDepth == 1)
			{
				// Group list - redraw pie chart and chart data table
				handleChartClickWhenGroupsLevel ( slice );
			}
          return;
        }
      }
    }

	if(currentDepth == 1)
	{
		// If the pie chart is already drawn - 100 perc. or eq
		if(pieChartDrawingIsFinished)
		{
			// User must have clicked outside the pie. Push any pulled-out slice back in.
			pushIn();
		}
	} else if(currentDepth == 2)
	{
		// Group list - redraw pie chart and chart data table
		handleChartClickWhenGroupsLevel ( -1 );
	}
  }


  /**
   * Process mouse clicks in the table area.
   *
   * Retrieve the slice number from the jQuery data stored in the
   * clicked table cell, then toggle the slice
   *
   * @param Event The click event
   */

  function handleTableMouseOver ( clickEvent ) {
	  // If the pie chart is already drawn - 100 perc. or eq
	  if(pieChartDrawingIsFinished)
	  {
		  // And current deep level in table is equals to the one which was when we assigned event
		   if(currentDepth == $(this).data( 'depthInTable' ))
		   {
    			var slice = $(this).data('slice');
				///$(this).effect("bounce", { times:3 }, 300);
    			toggleSlice ( slice );
		   }
	  }
  }

  /**
   * Process mouse clicks in the table area.
   *
   * Retrieve the slice number from the jQuery data stored in the
   * clicked table cell, then toggle the slice
   *
   * @param Event The click event
   */

  function handleTableOpenGroupTdElementClick ( clickEvent ) {
	// If the pie chart is already drawn - 100 perc. or eq
	if(pieChartDrawingIsFinished)
	{
		var slice = $(this).data('slice');
		///$(this).effect("bounce", { times:3 }, 300);
		//////toggleSlice ( slice );
		
		if ( slice == currentPullOutSlice ) {
			pushIn();
		} else {
			pushIn();
			startPullOut ( slice );
		}
	}
  }

  /**
   * Push a slice in or out.
   *
   * If it's already pulled out, push it in. Otherwise, pull it out.
   *
   * @param Number The slice index (between 0 and the number of slices - 1)
   */

  function toggleSlice ( slice ) {
    if ( slice == currentPullOutSlice ) {
		// DO nothing
        //pushIn();
    } else {
		pushIn();
        startPullOut ( slice );
    }
  }

  function toggleSliceOnChartClick ( slice ) {
    if ( slice == currentPullOutSlice ) {
		// DO nothing
        //pushIn();
    } else {
		pushIn();
        startPullOut ( slice );
    }
  }
 
  /**
   * Start pulling a slice out from the pie.
   *
   * @param Number The slice index (between 0 and the number of slices - 1)
   */

  function startPullOut ( slice ) {

    // Exit if we're already pulling out this slice
    if ( currentPullOutSlice == slice ) return;

    // Record the slice that we're pulling out, clear any previous animation, then start the animation
    currentPullOutSlice = slice;
    currentPullOutDistance = 0;
	currentBounceTimes = 0;
	currentMinPullOutDistance = minPullOutDistance;
	currentMaxPullOutDistance = maxPullOutDistance-6;
    clearInterval( animationId );
	// MAIN: Call the pullout function here
    animationId = setInterval( function() { animatePullOut( slice ); }, pullOutFrameInterval );

	var labelRow = null;
    // Highlight the corresponding row in the key table
	if(currentDepth == 1)
	{
		$('#chartData tr.group_collapsed').removeClass('highlight');
		labelRow = $('#chartData tr.group_collapsed:eq(' + (slice) + ')');
	} else if(currentDepth == 2)
	{
		$('#chartData tr.element_expanded').removeClass('highlight');
		labelRow = $('#chartData tr.element_expanded:eq(' + (slice) + ')');
	}
	labelRow.addClass('highlight');
  }

 
  /**
   * Draw a frame of the pull-out animation.
   *
   * @param Number The index of the slice being pulled out
   */

  function animatePullOut ( slice ) {

	if(currentBounceTimes % 2 == 0)
	{
		// Pull the slice out some more
		currentPullOutDistance += pullOutFrameStep;
	
		// If we've pulled it right out, stop animating
		if ( currentPullOutDistance >= currentMaxPullOutDistance ) {
			if(currentBounceTimes != 0)
			{
				currentMaxPullOutDistance -= (pullOutBounceStep / currentBounceTimes);
			}
		  	currentBounceTimes++;
		}
	} else
	{
		// Pull the slice out some more
		currentPullOutDistance -= (pullOutFrameStep);
	
		// If we've pulled it right out, stop animating
		if ( currentPullOutDistance <= currentMinPullOutDistance ) {
			currentMinPullOutDistance += (pullOutBounceStep / currentBounceTimes);
			currentBounceTimes++;
			///console.log('B: times:' + currentBounceTimes);
		}		
	}
		
	if(currentBounceTimes >= bounceTimes*2)
	{
		clearInterval( animationId );
		return;
	}
    // Draw the frame
    drawChart();
  }

 
  /**
   * Push any pulled-out slice back in.
   *
   * Resets the animation variables and redraws the chart.
   * Also un-highlights all rows in the table.
   */

  function pushIn() {
    currentPullOutSlice = -1;
    currentPullOutDistance = 0;
    clearInterval( animationId );
    drawChart();
    ///$('#chartData td').removeClass('highlight');
	$('#chartData tr.element_expanded').removeClass('highlight');
  }
 
 
  /**
   * Draw the chart.
   *
   * Loop through each slice of the pie, and draw it.
   */

  function drawChart()
  {
    // Get a drawing context
    var context = canvas.getContext('2d');
        
    // Clear the canvas, ready for the new frame
    context.clearRect ( 0, 0, canvasWidth, canvasHeight );

    // Draw each slice of the chart, skipping the pull-out slice (if any)
    for ( var slice in chartData ) {
      if ( slice != currentPullOutSlice ) drawSlice( context, slice );
    }

    // If there's a pull-out slice in effect, draw it.
    // (We draw the pull-out slice last so its drop shadow doesn't get painted over.)
    if ( currentPullOutSlice != -1 ) drawSlice( context, currentPullOutSlice );
  }


   function getSlicePercentageMultiplier(sliceStartAngle, sliceEndAngle, circleRadius)
   {
	    //  Length of circle external line
	   	var circleCircumference = 2 * Math.PI * circleRadius;
		
		// And then dinamically adjust to the current slice proportions
		
		// Compute the adjusted start and end angles for the slice
		var sliceAngleSize = Math.abs(sliceEndAngle - sliceStartAngle);
		
		///console.log(2 + " * " + Math.PI + " * " + circleRadius + " * " + sliceAngleSize + " / " + 360);
		var sliceLineLength = 2 * Math.PI * circleRadius * sliceAngleSize / 360;
		var animationPercentageAddMultiplier = Math.ceil(circleCircumference / sliceLineLength);

		return animationPercentageAddMultiplier;
   }
 
  
   function getNextSlicePercentage(currentPercentage, slicePercentageMultiplier)
   {
	   var newPercentage = currentPercentage+slicePercentageMultiplier;
	   if(newPercentage > 100)
	   {
		   newPercentage = 100;
	   }
	   
	   return newPercentage;
   }
  
  /**
   * Draw the chart - a long draw with intro
   *
   * Loop through each slice of the pie, and draw it.
   */

	function drawChartWithIntro()
	{
		// Get a drawing context
		var context = canvas.getContext('2d');
			
		// Clear the canvas, ready for the new frame
		context.clearRect ( 0, 0, canvasWidth, canvasHeight );
		
		currSlice = -1;
		totalSlices = chartData.length;
		
		drawNextSliceWithIntro(context, currSlice);
	}  
  
   function drawNextSliceWithIntro(context, currSlice)
   {
		currSlice++;
		if(currSlice >= totalSlices)
		{
			// Set that drawing is finished, so events become active
			/**DEBUG**/ if(debug) console.log("drawing is finished from 'drawNextSliceWithIntro'");
			pieChartDrawingIsFinished = true; // actualy this part is never used
			return;
		} else
		{
			clearInterval( introAnimationId );
			currentDrawnAnimationPercentage = 0;
			
			// Get current slice percentage multiplier
			var tmpMultiplier = getSlicePercentageMultiplier((chartData[currSlice]['startAngle']*180), (chartData[currSlice]['endAngle']*180), chartRadius);
			var slicePercentageAdd = drawnAnimationPercentageIncrementStep * tmpMultiplier;
			
			///console.log("CURR SLICE: " + currSlice + " OF " + totalSlices);
			/*console.log("Slice perc add(globalStep x multipier(startAngle, finish, radius) : " + slicePercentageAdd + " = " +
				drawnAnimationPercentageIncrementStep + " * " + 
				"[" + tmpMultiplier + " = mul(" + (chartData[currSlice]['startAngle']*180) + ", " + (chartData[currSlice]['endAngle']*180) + ", " + chartRadius + ") ]");*/
				
			// MAIN: Call the pullout function here
			introAnimationId = setInterval( function() { drawSliceWithIntro( context, currSlice, slicePercentageAdd ); }, pieStartupDrawingInterval );
		}
  }

  /**
   * Draw an individual slice in the chart.
   *
   * @param Context A canvas context to draw on  
   * @param Number The index of the slice to draw
   */

  function drawSlice ( context, slice ) {

    // Compute the adjusted start and end angles for the slice
    var startAngle = chartData[slice]['startAngle']  + chartStartAngle;
    var endAngle = chartData[slice]['endAngle']  + chartStartAngle;
      
    if ( slice == currentPullOutSlice ) {

      // We're pulling (or have pulled) this slice out.
      // Offset it from the pie centre, draw the text label,
      // and add a drop shadow.

      var midAngle = (startAngle + endAngle) / 2;
      var actualPullOutDistance = currentPullOutDistance * easeOut( currentPullOutDistance/maxPullOutDistance, .8 );
      startX = centreX + Math.cos(midAngle) * actualPullOutDistance;
      startY = centreY + Math.sin(midAngle) * actualPullOutDistance;
      context.fillStyle = 'rgb(' + chartColours[slice].join(',') + ')';
      context.textAlign = "center";
      context.font = pullOutLabelFont;
      context.fillText( chartData[slice]['label'], centreX + Math.cos(midAngle) * ( chartRadius + maxPullOutDistance + pullOutLabelPadding ), centreY + Math.sin(midAngle) * ( chartRadius + maxPullOutDistance + pullOutLabelPadding ) );
      context.font = pullOutValueFont;
      context.fillText( pullOutValuePrefix + chartData[slice]['value'] + " (" + ( parseInt( chartData[slice]['value'] / totalValue * 100 + .5 ) ) +  "%)", centreX + Math.cos(midAngle) * ( chartRadius + maxPullOutDistance + pullOutLabelPadding ), centreY + Math.sin(midAngle) * ( chartRadius + maxPullOutDistance + pullOutLabelPadding ) + 20 );
      context.shadowOffsetX = pullOutShadowOffsetX;
      context.shadowOffsetY = pullOutShadowOffsetY;
      context.shadowBlur = pullOutShadowBlur;

    } else {

      // This slice isn't pulled out, so draw it from the pie centre
      startX = centreX;
      startY = centreY;
    }

    // Set up the gradient fill for the slice
    var sliceGradient = context.createLinearGradient( 0, 0, canvasWidth*.75, canvasHeight*.75 );
    sliceGradient.addColorStop( 0, sliceGradientColour );
    sliceGradient.addColorStop( 1, 'rgb(' + chartColours[slice].join(',') + ')' );

    // Draw the slice
    context.beginPath();
    context.moveTo( startX, startY );
    context.arc( startX, startY, chartRadius, startAngle, endAngle, false );
    context.lineTo( startX, startY );
    context.closePath();
    context.fillStyle = sliceGradient;
    context.shadowColor = ( slice == currentPullOutSlice ) ? pullOutShadowColour : "rgba( 0, 0, 0, 0 )";
    context.fill();
    context.shadowColor = "rgba( 0, 0, 0, 0 )";

    // Style the slice border appropriately
    if ( slice == currentPullOutSlice ) {
      context.lineWidth = pullOutBorderWidth;
      context.strokeStyle = pullOutBorderStyle;
    } else {
      context.lineWidth = sliceBorderWidth;
      context.strokeStyle = sliceBorderStyle;
    }

    // Draw the slice border
    context.stroke();
  }


  /**
   * Draw an individual slice in the chart as step by step.
   *
   * @param Context A canvas context to draw on  
   * @param Number The index of the slice to draw
   */

  function drawSliceWithIntro ( context, slice, slicePercentageAdd ) {
		if(slice >= totalSlices)
		{
			// Set that drawing is finished, so events become active
			/**DEBUG**/ if(debug) console.log("drawing is finished from 'drawSliceWithIntro'");
			pieChartDrawingIsFinished = true; // actualy this part is never used
			return;
		}
	  
		// Increase percentage of drawn animation
		currentDrawnAnimationPercentage = getNextSlicePercentage(currentDrawnAnimationPercentage, slicePercentageAdd);
		///console.log("CALL DSWI ["+slice+"], perc after:"+ currentDrawnAnimationPercentage);

		// Compute the adjusted start and end angles for the slice
		var startAngle = chartData[slice]['startAngle']  + chartStartAngle;
		var endAngle = chartData[slice]['endAngle']  + chartStartAngle;
		
		/********************* ANIMATION PART: START *********************************/
		currentEndAngle = startAngle + (Math.abs(endAngle - startAngle) / 100 * currentDrawnAnimationPercentage);
		/*****************************************************************************/  
		  
		// This slice isn't pulled out, so draw it from the pie centre
		startX = centreX;
		startY = centreY;
	
		// Set up the gradient fill for the slice
		var sliceGradient = context.createLinearGradient( 0, 0, canvasWidth*.75, canvasHeight*.75 );
		sliceGradient.addColorStop( 0, sliceGradientColour );
		sliceGradient.addColorStop( 1, 'rgb(' + chartColours[slice].join(',') + ')' );
	
		// Draw the slice
		context.beginPath();
		context.moveTo( startX, startY );
		// we are using 'currentEndAngle' instead of 'endAngle' because we want an animation step by step pie draw
		context.arc( startX, startY, chartRadius, startAngle, currentEndAngle, false );
		context.lineTo( startX, startY );
		context.closePath();
		context.fillStyle = sliceGradient;
		context.shadowColor = ( slice == currentPullOutSlice ) ? pullOutShadowColour : "rgba( 0, 0, 0, 0 )";
		context.fill();
		context.shadowColor = "rgba( 0, 0, 0, 0 )";
	
		// Style the slice border appropriately
		context.lineWidth = sliceBorderWidth;
		context.strokeStyle = sliceBorderStyle;
	
		// Draw the slice border
		context.stroke();
		
		if(currentDrawnAnimationPercentage >= 100)
		{
			clearInterval( introAnimationId );
			drawNextSliceWithIntro(context, slice);
		}
  }


  /**
   * Easing function.
   *
   * A bit hacky but it seems to work! (Note to self: Re-read my school maths books sometime)
   *
   * @param Number The ratio of the current distance travelled to the maximum distance
   * @param Number The power (higher numbers = more gradual easing)
   * @return Number The new ratio
   */

  function easeOut( ratio, power ) {
    return ( Math.pow ( 1 - ratio, power ) + 1 );
  }

};