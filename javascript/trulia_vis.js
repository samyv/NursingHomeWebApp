
//////////////////////////////////////////////////////
///////////////////////D3JS///////////////////////////
//////////////////////////////////////////////////////

const margin = { top: 30, right: 0, bottom: 100, left: 120 }
const width = 500 - margin.left - margin.right
const height = 250 - margin.top - margin.bottom
const gridSize = Math.floor(width / 17)
const legendElementWidth = gridSize*2
const buckets = 9
const colors = ["#ff6666","#ffb366","#ffff66","#b3ff66","#66ff66"]
const sectionsNames = ["Privacy", "Eten en maaltijden", "Veiligheid","Zich prettig voelen","Autonomie","Respect","Reageren door medewerkers op vragen","Een band voelen met wie hier werkt","Keuze aan activiteiten","Persoonlijke omgang"," Informatie vanuit het woonzorgcentrum"]
const sections = ["1","2","3","4","5","6","7","8","9","10","11"]
const times = [1,2,3,4,5,6,7,8,9,10,11]
const xLabels = [1,2,3,4,5,6,7]
const hash = []

for(var i = 0;i < sections.length;i++){
	hash[sections[i]] = times[i];
}

const svg = d3.select("#chart").append("svg")
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
	.append("g")
	.attr("transform", "translate("+ (margin.left) + "," + margin.top + ")");

/** Y-AXIS => all the section labels**/
const sectionLabels= svg.selectAll(".sectionLabel")
	.data(sectionsNames)
	.enter().append("text")
	.text(function (d) { return d; })
	.attr("x", 0)
	.attr("y", (d, i) => i * gridSize)
	.style("text-anchor", "end")
	.attr("transform", "translate(-6," + gridSize / 1.5 + ")")
	.attr("class","sectionLabel mono axis axis-workweek");

/** X-AXIS **/
const questionLabels = svg.selectAll(".timeLabel")
	.data(xLabels)
	.enter().append("text")
	.text((d,i) => i+1)
	.attr("x", (d, i) => i * gridSize)
	.attr("y", 0)
	.style("text-anchor", "middle")
	.attr("transform", "translate(" + gridSize / 2 + ", -6)")
	.attr("class","timeLabel mono axis axis-worktime");


Array.prototype.max = function() {
	return Math.max.apply(null, this);
};

Array.prototype.min = function() {
	return Math.min.apply(null, this);
};
/****/
const heatmapChart = function(p_data){
	let values = p_data.data;
	let domain = values.slice();
	domain.unshift(0);
	domain.push(3)
	let keys = p_data.keys;
	const colorScale = d3.scaleQuantile()
		.domain(domain)
		.range(colors);
	const cards = svg.selectAll(".section")
		.data(values);
	cards.append("title");

	cards.enter().append("rect")
		.attr("x",(d,i) => keys[i][1]*gridSize-gridSize)
		.attr("y",(d,i) => hash[keys[i][0]]*gridSize)
		.attr("rx", gridSize/2)
		.attr("ry", gridSize/2)
		.attr("class", "hour bordered")
		.attr("width", 0)
		.attr("height", gridSize)
		.style("fill", colors[0])
		.merge(cards)
		.transition()
		.duration(1250  )
		.style("fill", (d) =>colorScale(d))
		.attr("rx", 4)
		.attr("ry", 4)
		.attr("width", gridSize)
		.ease(d3.easeCircleOut);
	// .attr("height", gridSize)

	cards.select("title").text(function(d) { return d.value; });

	cards.exit().remove();

	var legend = svg.selectAll(".legend")
		.data([0].concat(colorScale.quantiles()), function(d) { return d; });

	legend.enter().append("g")
		.attr("class", "legend");

	legend.append("rect")
		.attr("x", function(d, i) { return legendElementWidth * i; })
		.attr("y", height)
		.attr("width", legendElementWidth)
		.attr("height", gridSize / 2)
		.style("fill", function(d, i) { return colors[i]; });

	legend.append("text")
		.attr("class", "mono")
		.text(function(d) { return "≥ " + Math.round(d); })
		.attr("x", function(d, i) { return legendElementWidth * i; })
		.attr("y", height + gridSize);

	legend.exit().remove();


}

function drawChart(testdata) {
    var data = {}
    var datadummy = [];
    datadummy['data'] = []
    for(var i = 0; i < testdata.length; i++){
        for(var key in testdata[i]){
            datadummy[testdata[i]['questionType']+testdata[i]['positionNum']] = testdata[i]['answer'];
        }
    }
    data['input'] = []
    data['input']['data'] = []
    data['input']['data'] = Object.values(datadummy);
    data['input']['keys'] = []
    data['input']['keys'] = Object.keys(datadummy);
    data['range'] = [1,5];
    console.log(data);
    heatmapChart(data.input)
}