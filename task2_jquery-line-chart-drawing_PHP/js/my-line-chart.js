/**
 * JS graph generator
 * @author - Kestutis ITDev
 * @date - 2011.07.10
 * @updated - 2011.07.12
 * @version - 5.0
*/
// JavaScript Document
$(document).ready(function() {
	dataReaderAndLineGraphLoader();
});

function dataReaderAndLineGraphLoader()
{
	var currentList = $('#existing').text();
	var forecastedList = $('#proposed').text();
	var splitedCurrent = currentList.split(',');
	var splitedForecasted = forecastedList.split(',');
	var xValues = new Array();
	var xLen = splitedCurrent.length;
	for(var i=0;i<xLen;i++)
	{
		var currVal = i / 12;
		xValues[i] = currVal;
	}
	var totalYears = Math.floor((splitedCurrent.length) / 12);

	
	xValueGroups = [xValues,xValues];
	yValueGroups = [splitedForecasted,splitedCurrent];
	
	//console.log('Lenght of x: ', xLen);
	//console.log('currentList: ', currentList);
	//console.log('forecastedList: ', forecastedList);
	//console.log('Total years: ' + totalYears);
	//console.log(xValueGroups);
	//console.log(yValueGroups);
	
	drawLineGraph(xValueGroups,yValueGroups);
}


function drawLineGraph(xValueGroups,yValueGroups)
{
	var paper = Raphael("holder");
	paper.g.txtattr = {font: "16px 'Fontin Sans', Fontin-Sans, sans-serif", fill: "#668DA1", "font-weight": "bold"};
	paper.g.text(70, 10, "Payments");
	
	paper.g.txtattr = {font: "12px 'Fontin Sans', Fontin-Sans, sans-serif", fill: "#5ECEEF", "font-weight": "normal"};
	paper.g.text(330, 10, "explain");
	
	paper.g.txtattr = {font: "11px 'Fontin Sans', Fontin-Sans, sans-serif", fill: "#888D89", "font-weight": "normal"};
	paper.g.text(210, 270, "Years");
	
	// pos X, pos Y, axis - bottom and left axis
	// Gutter: the width of axis labels in px
	var lines = paper.g.linechart(10, 10, 400, 260, xValueGroups, yValueGroups, {axis: "0 0 1 1", gutter: 30, axisystep: 5, axisxstep: 16});
	
	// Add dollar sign prefix to Y axis labels
	for(var x=0; x < lines.axis[1].text.items.length; x++)
	{
		//console.log(lines.axis[1].text.items[x]);
		originalText = lines.axis[1].text.items[x].attr('text');
		//alert(originalText);
		var newText = '$' + originalText;
		lines.axis[1].text.items[x].attr({'text': newText});
	}
	
	// Now I'm becoming a geek of Raphael :) - the tricky one :)
	
	// Make a delayed drawing for line 1
	var cur1=0;
	var path1 = paper.path(lines.pathOfList1[cur1++]
	).attr({stroke:Raphael.fn.g.colors[0],'stroke-width': 1});
	var animate1 = function()
	{
		if (cur1 < lines.pathOfList1.length)
		{
			path1.animate(
				{path:lines.pathOfList1[cur1++]},
				60, "<>", animate1
			);
		}
	}
	setTimeout(animate1,500);
	
	// Make a delayed drawing for line 2
	var cur2=0;
	var path2 = paper.path(lines.pathOfList2[cur2++]
	).attr({stroke:Raphael.fn.g.colors[1],'stroke-width': 1});
	var animate2 = function()
	{
		if (cur2 < lines.pathOfList2.length)
		{
			path2.animate(
				{path:lines.pathOfList2[cur2++]},
				60, "<>", animate2
			);
		}
	}
	setTimeout(animate2,500);
      
	  
}
