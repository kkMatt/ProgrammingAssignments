/*!
 * g.Raphael 0.4.2 - Charting library, based on Raphaël
 *
 * Rewroten & extended by Kestutis Matuliauskas
 * @author - Kestutis Matuliauskas, Dmitry Baranovskiy
 * @date - 2011.07.10
 * @updated - 2011.07.12
 * @version - 6.0
 */
Raphael.fn.g.linechart = function (x, y, width, height, valuesx, valuesy, opts) {
    function shrink(values, dim) {
        var k = values.length / dim,
            j = 0,
            l = k,
            sum = 0,
            res = [];
        while (j < values.length) {
            l--;
            if (l < 0) {
                sum += values[j] * (1 + l);
                res.push(sum / k);
                sum = values[j++] * -l;
                l += k;
            } else {
                sum += values[j++];
            }
        }
        return res;
    }
    function getAnchors(p1x, p1y, p2x, p2y, p3x, p3y) {
        var l1 = (p2x - p1x) / 2,
            l2 = (p3x - p2x) / 2,
            a = Math.atan((p2x - p1x) / Math.abs(p2y - p1y)),
            b = Math.atan((p3x - p2x) / Math.abs(p2y - p3y));
        a = p1y < p2y ? Math.PI - a : a;
        b = p3y < p2y ? Math.PI - b : b;
        var alpha = Math.PI / 2 - ((a + b) % (Math.PI * 2)) / 2,
            dx1 = l1 * Math.sin(alpha + a),
            dy1 = l1 * Math.cos(alpha + a),
            dx2 = l2 * Math.sin(alpha + b),
            dy2 = l2 * Math.cos(alpha + b);
        return {
            x1: p2x - dx1,
            y1: p2y + dy1,
            x2: p2x + dx2,
            y2: p2y + dy2
        };
    }
    opts = opts || {};
    if (!this.raphael.is(valuesx[0], "array")) {
        valuesx = [valuesx];
    }
    if (!this.raphael.is(valuesy[0], "array")) {
        valuesy = [valuesy];
    }
    var gutter = opts.gutter || 10,
        len = Math.max(valuesx[0].length, valuesy[0].length),
        that = this,
        columns = null,
        dots = null,
        chart = this.set(),
        path = [];

    for (var i = 0, ii = valuesy.length; i < ii; i++)
	{
        len = Math.max(len, valuesy[i].length);
    }
    for (i = 0, ii = valuesy.length; i < ii; i++)
	{
        if (valuesy[i].length > width - 2 * gutter)
		{
            valuesy[i] = shrink(valuesy[i], width - 2 * gutter);
            len = width - 2 * gutter;
        }
        if (valuesx[i] && valuesx[i].length > width - 2 * gutter)
		{
            valuesx[i] = shrink(valuesx[i], width - 2 * gutter);
        }
    }
    var allx = Array.prototype.concat.apply([], valuesx),
        ally = Array.prototype.concat.apply([], valuesy),
        xdim = this.g.snapEnds(Math.min.apply(Math, allx), Math.max.apply(Math, allx), valuesx[0].length - 1),
        minx = xdim.from,
        maxx = xdim.to,
		ydim = this.g.snapEnds(0, Math.max.apply(Math, ally), valuesy[0].length - 1),
		miny = ydim.from,
        maxy = ydim.to,
        kx = (width - gutter * 2) / ((maxx - minx) || 1),
        ky = (height - gutter * 2) / ((maxy - miny) || 1);

    var axis = this.set();
    if (opts.axis)
	{
        var ax = (opts.axis + "").split(/[,\s]+/);
        +ax[0] && axis.push(this.g.axis(x + gutter, y + gutter, width - 2 * gutter, minx, maxx, opts.axisxstep || Math.floor((width - 2 * gutter) / 20), 2));
        +ax[1] && axis.push(this.g.axis(x + width - gutter, y + height - gutter, height - 2 * gutter, miny, maxy, opts.axisystep || Math.floor((height - 2 * gutter) / 20), 3));
        +ax[2] && axis.push(this.g.axis(x + gutter, y + height - gutter, width - 2 * gutter, minx, maxx, opts.axisxstep || Math.floor((width - 2 * gutter) / 20), 0));
        +ax[3] && axis.push(this.g.axis(x + gutter, y + height - gutter, height - 2 * gutter, miny, maxy, opts.axisystep || Math.floor((height - 2 * gutter) / 20), 1));
    }
    var lines = this.set(),
        symbols = this.set(),
        line,
		animationList = new Array(),
		animationListNonJoin = new Array();
    for (i = 0, ii = valuesy.length; i < ii; i++)
	{
        path = [];
        for (var j = 0, jj = valuesy[i].length; j < jj; j++)
		{
            var X = x + gutter + ((valuesx[i] || valuesx[0])[j] - minx) * kx,
                Y = y + height - gutter - (valuesy[i][j] - miny) * ky;
            path = path.concat([j ? "L" : "M", X, Y]);
        }
		//console.log('LINE PATH:');
		//console.log(path);
		
		animationList[i] = path.join(" ");
		animationListNonJoin[i] = path;
    }
	
	chart.push(axis);
    chart.axis = axis;

	
	var lengthLine1 = Math.floor(animationListNonJoin[0].length / 3); // just in case, but allways should be only integer
	var lengthLine2 = Math.floor(animationListNonJoin[1].length / 3); // just in case, but allways should be only integer
	var path1 = "", path2 = "";
	var pathList1 = new Array(), pathList2 = new Array();
	
	for(var i=0; i < lengthLine1; i++)
	{
		// Draw line 1
		var L1_1 = animationListNonJoin[0][i*3+0];
		var L1_2 = animationListNonJoin[0][i*3+1];
		var L1_3 = animationListNonJoin[0][i*3+2];
		
		path1 = path1 + L1_1 + " " + L1_2 + " " + L1_3 + " ";
		pathList1[i] = path1;
		
		console.log("Path1 ["+ i +"]: " + path1);
	}
	
	for(var i=0; i < lengthLine2; i++)
	{
		// Draw line 2
		var L2_1 = animationListNonJoin[1][i*3+0];
		var L2_2 = animationListNonJoin[1][i*3+1];
		var L2_3 = animationListNonJoin[1][i*3+2];
		
		path2 = path2 + L2_1 + " " + L2_2 + " " + L2_3 + " ";
		pathList2[i] = path2;
		
		console.log("Path2 ["+ i +"]: " + path2);
	}

	chart.pathOfList1 = pathList1;
	chart.pathOfList2 = pathList2;

    return chart;
};
