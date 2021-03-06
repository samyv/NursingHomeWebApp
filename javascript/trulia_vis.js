
//////////////////////////////////////////////////////
///////////////////////D3JS///////////////////////////
//////////////////////////////////////////////////////


const margin = { top: 30, right: 0, bottom: 100, left: 320 }
const width = 600 - margin.left - margin.right
const height = 360 - margin.top - margin.bottom
const gridSize = Math.floor(width / 11)
const legendElementWidth = gridSize;
const buckets = 9
const colors = ["#ff6666","#ffb366","#ffff66","#b3ff66","#66ff66"]
const times = [1,2,3,4,5,6,7,8,9,10,11]






Array.prototype.max = function() {
	return Math.max.apply(null, this);
};

Array.prototype.min = function() {
	return Math.min.apply(null, this);
};
/****/
const heatmapChart = function(p_data, sections){


    $svg = $("#chart").children()
    if($svg.length !== 0){
        $svg.remove()
    }

    const svg = d3.select("#chart").append("svg")
		.attr("id", "heatmap")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate("+ (margin.left) + "," + margin.top + ")");

    p_data.forEach(function (d) {
    	d.answer = parseInt(d.answer);
    	d.questionType =+ parseInt(d.questionType);
    	d.positionNum =+ parseInt(d.positionNum);
	});

    // const questionLabels = svg.selectAll(".timeLabel")
    //     .data(xLabels)
    //     .enter().append("text")
    //     .text((d,i) => i+1)
    //     .attr("x", (d, i) => i * gridSize)
    //     .attr("y", 0)
    //     .style("text-anchor", "middle")
    //     .attr("transform", "translate(" + gridSize / 2 + ", -6)")
    //     .attr("class","timeLabel mono axis axis-worktime");


    const sectionLabels= svg.selectAll(".sectionLabel")
        .data(sections)
        .enter().append("text")
        .text(function (d,i) {
        	return d.sectionType + ": " + d.score_per_category;})
        .attr("x", 0)
        .attr("y", (d, i) => i * gridSize)
        .style("text-anchor", "end")
        .attr("transform", "translate(-6," + gridSize / 1.5 + ")")
        .attr("class","sectionLabel mono axis axis-workweek");

    var div = d3.select("body").append("div")
        .attr("class", "tooltip")
        .style("opacity", 0);

    const colorScale = d3.scaleQuantile()
		.domain(d3.extent(p_data, function (d) {
			return d.answer;
        }))
		.range(colors);
	const cards = svg.selectAll(".section")
		.data(p_data);
	cards.enter().append("rect")
		.attr("x",(d,i) => (d.positionNum*gridSize-gridSize))
		.attr("y",(d,i) => ((d.questionType-1)*gridSize))
		.attr("class", "hour bordered")
		.attr("width", gridSize-2)
		.attr("height", gridSize-2)
		.style("fill", colors[0])
		.attr("id",(d) => (d.questionText))
		.merge(cards)
		.transition()
		.duration(1250  )
		.style("fill", (d) =>colorScale(d.answer))
		.attr("rx", 4)
		.attr("ry", 4)
		.ease(d3.easeCircleOut);

	var tip = d3.tip()
		.attr('class', 'd3-tip')
		.style("visibility", "visible")
		.offset([-20,0])
		.html(function(d) {
			return d.questionText + ": " + Math.round(d.answer);
		});
	svg.call(tip);

	tip(svg.append("g"));

	rectangles=svg.selectAll('rect');
	rectangles.on("mouseover", tip.show)
        .on("mouseout",tip.hide);


    var legend = svg.selectAll(".legend")
        .data([0].concat(colorScale.quantiles()), function(d) { return d; })
		.enter().append("g")
        .attr("class", "legendTile");

    var legendTile = svg.selectAll(".legendTile")
    legendTile.append("rect")
		.attr("x", function(d, i) { return gridSize * 9; })
		.attr("y", function(d, i) { return (i * legendElementWidth + 7); })
		.attr("width", gridSize/2)
		.attr("height", gridSize/2)
		.style("fill", function(d, i) { return colors[i]; })
		.attr("class", "hour bordered")


	legendTile.append("text")
		.attr("class", "mono")
		.text(function(d,i) { return  i+1; })
		.attr("x", function(d, i) { return gridSize * 9 + 25; })
		.attr("y", function(d, i) { return (i * legendElementWidth + 20); })

	var title = svg.append("text")
		.attr("class", "mono")
		.attr("x", gridSize * 9)
		.attr("y", - 6)
		.style("font-size", "14px")
		.text("Legend");


	cards.select("title").text(function(d) { return d.value; });

	cards.exit().remove();
}