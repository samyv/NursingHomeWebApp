var testdata = [{"answer":"3","questionType":"1","positionNum":"1"},{"answer":"1","questionType":"1","positionNum":"2"},{"answer":"2","questionType":"2","positionNum":"1"},{"answer":"5","questionType":"2","positionNum":"2"},{"answer":"2","questionType":"2","positionNum":"3"},{"answer":"2","questionType":"2","positionNum":"4"},{"answer":"1","questionType":"2","positionNum":"5"},{"answer":"3","questionType":"3","positionNum":"1"},{"answer":"3","questionType":"3","positionNum":"2"},{"answer":"4","questionType":"3","positionNum":"3"},{"answer":"4","questionType":"4","positionNum":"1"},{"answer":"1","questionType":"4","positionNum":"2"},{"answer":"3","questionType":"4","positionNum":"3"},{"answer":"1","questionType":"4","positionNum":"4"},{"answer":"3","questionType":"4","positionNum":"5"},{"answer":"3","questionType":"4","positionNum":"6"},{"answer":"1","questionType":"5","positionNum":"1"},{"answer":"4","questionType":"5","positionNum":"2"},{"answer":"5","questionType":"5","positionNum":"3"},{"answer":"4","questionType":"5","positionNum":"4"},{"answer":"3","questionType":"5","positionNum":"5"},{"answer":"5","questionType":"5","positionNum":"6"},{"answer":"3","questionType":"5","positionNum":"7"},{"answer":"5","questionType":"6","positionNum":"1"},{"answer":"2","questionType":"6","positionNum":"2"},{"answer":"2","questionType":"6","positionNum":"3"},{"answer":"1","questionType":"6","positionNum":"4"},{"answer":"5","questionType":"7","positionNum":"1"},{"answer":"5","questionType":"7","positionNum":"2"},{"answer":"5","questionType":"7","positionNum":"3"},{"answer":"2","questionType":"7","positionNum":"4"},{"answer":"2","questionType":"7","positionNum":"5"},{"answer":"4","questionType":"7","positionNum":"6"},{"answer":"2","questionType":"8","positionNum":"1"},{"answer":"2","questionType":"8","positionNum":"2"},{"answer":"4","questionType":"8","positionNum":"3"},{"answer":"4","questionType":"8","positionNum":"4"},{"answer":"2","questionType":"8","positionNum":"5"},{"answer":"5","questionType":"9","positionNum":"1"},{"answer":"4","questionType":"9","positionNum":"2"},{"answer":"1","questionType":"9","positionNum":"3"},{"answer":"1","questionType":"9","positionNum":"4"},{"answer":"2","questionType":"9","positionNum":"5"},{"answer":"4","questionType":"10","positionNum":"1"},{"answer":"5","questionType":"10","positionNum":"2"},{"answer":"3","questionType":"10","positionNum":"3"},{"answer":"1","questionType":"10","positionNum":"4"},{"answer":"1","questionType":"10","positionNum":"5"},{"answer":"1","questionType":"11","positionNum":"1"},{"answer":"3","questionType":"11","positionNum":"2"},{"answer":"2","questionType":"11","positionNum":"3"},{"answer":"5","questionType":"11","positionNum":"4"}];


var data = {}
var dummy = getAllScoresPerSection(rawData)
var datadummy = [];
datadummy['data'] = []
for(var i = 0; i < testdata.length; i++){
	for(var key in testdata[i]){
		datadummy[testdata[i]['questionType']+testdata[i]['positionNum']] = testdata[i]['answer'];
	}
}
console.log(dummy);
data['input'] = []
data['input']['data'] = []
data['input']['data'] = Object.values(datadummy);
data['input']['keys'] = []
data['input']['keys'] = Object.keys(datadummy);
data['range'] = [1,5];
console.log(data);
function getAllScoresPerSection(rawDat) {
	//loop every question
	let range = [5,0]
	temp_scores = [] //like dummy
	var score_section = []
	var section = "A";
	count = 1
	newSection = false;
	for(i in rawDat){
		//get section of question
		var question_Section = rawDat[i]['Code'].split("")[0];

		//check if still in same section
		if(section != question_Section){
			//NO => push previous section and empty section array
			temp_scores.push(score_section)
			var score_section = []
			newSection = true;
			count = 1;
		}

		//push question score into section score and update section
		const score = calculateScore(rawDat[i])
		score_section[question_Section+""+count]  = score;
		if(score > range[1]){
			range[1] = score
		} else if(score < range[0]){
			range[0] = score
		}
		count++;
		section = question_Section
	}
	//push last sections
	temp_scores.push(score_section)
	return {temp_scores,range}
}
function calculateScore(question) {
	var answers = ["Never or Rarely","Sometimes","Most of the time","Always"]
	// calculate score: always(3), MOTT(2), SMT(1), NOR(0)
	var total = 0
	var score = 0
	answers.forEach(function(answer,i) {
		total += question[answer]
		score += question[answer]*i
	})
	//normalize score
	score /= total;
	return Number((score).toFixed(3))
}

//////////////////////////////////////////////////////
///////////////////////D3JS///////////////////////////
//////////////////////////////////////////////////////

const margin = { top: 30, right: 0, bottom: 100, left: 300 }
const width = 960 - margin.left - margin.right
const height = 650 - margin.top - margin.bottom
const gridSize = Math.floor(width / 15.5)
const legendElementWidth = gridSize*2
const buckets = 9
const colors = ["#ff6666","#ff8c66","#ffb366","#ffd966","#ffff66","#d9ff66","#b3ff66","#8cff66","#66ff66"]
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
heatmapChart(data.input)
