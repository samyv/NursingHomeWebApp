<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 18/11/2018
 * Time: 0:30
 */
?>
<html>
<head>
	<title>Simple d3js example</title>
	<link href="<?php echo base_url(); ?>assets/css/resident_dashboard.css" rel='stylesheet' type='text/css' />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v4.js"></script>
</head>
<body>
<div class="grid-container">
	<div class="picture">
		PICTURE
<!--		<img src="https://i.pinimg.com/originals/d0/dd/2c/d0dd2c8bb30ef5281ebb4472f1cc71fa.jpg" />-->
	</div>
	<div class="info">
		<?php
		echo $resident['firstname'].' '.$resident['lastname'];
		echo "<br>";
		$dateOfBirth = $resident['birthdate'];
		date_default_timezone_set("Europe/Brussels");
		$today = date("Y-m-d");
		$diff = date_diff(date_create($dateOfBirth),date_create($today));
		echo "Leeftijd: " . $diff->format('%y');
		echo "<br>";
		echo "Geslacht: ";
		if($resident['gender'] == 'm'){
			echo "man";
		} else {
			echo "vrouw";
		}
		echo "<br>";
		echo "Kamer: ".$resident['room'];
		echo "<br>";
		echo "Allergieën: Geen";
		?>
	</div>
	<div class="back_start"></div>
	<div class="back_buttons">
		<button>RETURN TO HOME</button>
		<br>
		<button>RETURN</button>
	</div>
	<div class="toolbar">TOOLBAR</div>
	<div class="visualisation">
		<div id="chart"></div>
	</div>
	<div class="hint">
		<text rows="4" cols="50">Jozef doesn't like the food, let's talk to him!</text>
	</div>
	<div class="print">
		<input type="submit"></input>
	</div>
</div>
<script>
	var rawData = [{
		"Code": "A1",
		"Never or Rarely": 664,
		"Sometimes": 732,
		"Most of the time": 3869,
		"Always": 16461
	},{
		"Code": "A2",
		"Never or Rarely": 534,
		"Sometimes": 1450,
		"Most of the time": 9159,
		"Always": 20655
	},{
		"Code": "B1",
		"Never or Rarely": 1684,
		"Sometimes": 5303,
		"Most of the time": 13690,
		"Always": 11172},{
		"Code": "B2",
		"Never or Rarely": 22130,
		"Sometimes": 3805,
		"Most of the time": 3338,
		"Always": 2266
	},{
		"Code": "B3",
		"Never or Rarely": 1493,
		"Sometimes": 3258,
		"Most of the time": 12691,
		"Always": 14424
	},{
		"Code": "B4",
		"Never or Rarely": 2747,
		"Sometimes": 6420,
		"Most of the time": 12466,
		"Always": 10229
	},{
		"Code": "B5",
		"Never or Rarely": 806,
		"Sometimes": 3220,
		"Most of the time": 12542,
		"Always": 15084
	},{
		"Code": "C1",
		"Never or Rarely": 1407,
		"Sometimes": 4639,
		"Most of the time": 12406,
		"Always": 13338
	},{
		"Code": "C2",
		"Never or Rarely": 2163,
		"Sometimes": 2620,
		"Most of the time": 9239,
		"Always": 17820
	},{
		"Code": "C3",
		"Never or Rarely": 1028,
		"Sometimes": 1773,
		"Most of the time": 8984,
		"Always": 20066
	},{
		"Code": "D1",
		"Never or Rarely": 436,
		"Sometimes": 1951,
		"Most of the time": 10887,
		"Always": 18673
	},{
		"Code": "D2",
		"Never or Rarely": 3801,
		"Sometimes": 4189,
		"Most of the time": 8567,
		"Always": 14810
	},{
		"Code": "D3",
		"Never or Rarely": 3688,
		"Sometimes": 4709,
		"Most of the time": 10195,
		"Always": 13227
	},{
		"Code": "D4",
		"Never or Rarely": 6607,
		"Sometimes": 2778,
		"Most of the time": 6658,
		"Always": 15494
	},{
		"Code": "D5",
		"Never or Rarely": 6580,
		"Sometimes": 7505,
		"Most of the time": 9356,
		"Always": 8502
	},{
		"Code": "D6",
		"Never or Rarely": 25847,
		"Sometimes": 4732,
		"Most of the time": 882,
		"Always": 449
	},{
		"Code": "E1",
		"Never or Rarely": 17927,
		"Sometimes": 4729,
		"Most of the time": 4318,
		"Always": 4227
	},{
		"Code": "E2",
		"Never or Rarely": 11383,
		"Sometimes": 3577,
		"Most of the time": 6740,
		"Always": 9981
	},{
		"Code": "E3",
		"Never or Rarely": 6169,
		"Sometimes": 2530,
		"Most of the time": 7081,
		"Always": 15957
	},{
		"Code": "E4",
		"Never or Rarely": 4724,
		"Sometimes": 2991,
		"Most of the time": 8830,
		"Always": 15008
	},{
		"Code": "E5",
		"Never or Rarely": 7602,
		"Sometimes": 2893,
		"Most of the time": 8747,
		"Always": 12322
	},{
		"Code": "E6",
		"Never or Rarely": 3878,
		"Sometimes": 2381,
		"Most of the time": 6513,
		"Always": 18981
	},{
		"Code": "E7",
		"Never or Rarely": 2314,
		"Sometimes": 2030,
		"Most of the time": 8987,
		"Always": 18435
	},{
		"Code": "F1",
		"Never or Rarely": 311,
		"Sometimes": 2258,
		"Most of the time": 11014,
		"Always": 18357
	},{
		"Code": "F2",
		"Never or Rarely": 1230,
		"Sometimes": 5134,
		"Most of the time": 13680,
		"Always": 11898
	},{
		"Code": "F3",
		"Never or Rarely": 3581,
		"Sometimes": 4488,
		"Most of the time": 9812,
		"Always": 13450
	},{
		"Code": "F4",
		"Never or Rarely": 1447,
		"Sometimes": 5074,
		"Most of the time": 13144,
		"Always": 12036
	},{
		"Code": "G1",
		"Never or Rarely": 1451,
		"Sometimes": 3681,
		"Most of the time": 13340,
		"Always": 13242
	},{
		"Code": "G2",
		"Never or Rarely": 2156,
		"Sometimes": 7752,
		"Most of the time": 14260,
		"Always": 7631
	},{
		"Code": "G3",
		"Never or Rarely": 4731,
		"Sometimes": 9365,
		"Most of the time": 11686,
		"Always": 5296
	},{
		"Code": "G4",
		"Never or Rarely": 525,
		"Sometimes": 2090,
		"Most of the time": 9880,
		"Always": 19422
	},{
		"Code": "G5",
		"Never or Rarely": 4764,
		"Sometimes": 8329,
		"Most of the time": 12098,
		"Always": 6656
	},{
		"Code": "G6",
		"Never or Rarely": 549,
		"Sometimes": 3138,
		"Most of the time": 12681,
		"Always": 15427
	},{
		"Code": "H1",
		"Never or Rarely": 12554,
		"Sometimes": 8899,
		"Most of the time": 7655,
		"Always": 2572
	},{
		"Code": "H2",
		"Never or Rarely": 10321,
		"Sometimes": 8673,
		"Most of the time": 8385,
		"Always": 4394
	},{
		"Code": "H3",
		"Never or Rarely": 7923,
		"Sometimes": 12178,
		"Most of the time": 8661,
		"Always": 3122
	},{
		"Code": "H4",
		"Never or Rarely": 6173,
		"Sometimes": 9976,
		"Most of the time": 10849,
		"Always": 4814
	},{
		"Code": "H5",
		"Never or Rarely": 14521,
		"Sometimes": 8409,
		"Most of the time": 7715,
		"Always": 1045
	},{
		"Code": "I1",
		"Never or Rarely": 20567,
		"Sometimes": 5223,
		"Most of the time": 3821,
		"Always": 1962
	},{
		"Code": "I2",
		"Never or Rarely": 12460,
		"Sometimes": 8226,
		"Most of the time": 7509,
		"Always": 3437
	},{
		"Code": "I3",
		"Never or Rarely": 4126,
		"Sometimes": 3552,
		"Most of the time": 6797,
		"Always": 17005
	},{
		"Code": "I4",
		"Never or Rarely": 6677,
		"Sometimes": 7942,
		"Most of the time": 9991,
		"Always": 7066
	},{
		"Code": "I5",
		"Never or Rarely": 18361,
		"Sometimes": 7183,
		"Most of the time": 4115,
		"Always": 1697
	},{
		"Code": "J1",
		"Never or Rarely": 13256,
		"Sometimes": 8083,
		"Most of the time": 6295,
		"Always": 3980
	},{
		"Code": "J2",
		"Never or Rarely": 22908,
		"Sometimes": 6499,
		"Most of the time": 1751,
		"Always": 472
	},{
		"Code": "J3",
		"Never or Rarely": 18281,
		"Sometimes": 6083,
		"Most of the time": 3744,
		"Always": 2496
	},{
		"Code": "J4",
		"Never or Rarely": 7979,
		"Sometimes": 9324,
		"Most of the time": 9776,
		"Always": 4503
	},{
		"Code": "J5",
		"Never or Rarely": 13287,
		"Sometimes": 9414,
		"Most of the time": 6370,
		"Always": 2547
	}];

	var data = {}
	var dummy = getAllScoresPerSection(rawData)
	var datadummy = [];
	datadummy['data'] = []
	for(var i = 0; i < dummy.temp_scores.length; i++){
		for(var key in dummy.temp_scores[i]){
			datadummy['data'][key] = dummy.temp_scores[i][key]
			// datadummy.push(el);
		}
	}
	data['input'] = []
	data['input']['data'] = []
	data['input']['data'] = Object.values(datadummy.data);
	data['input']['keys'] = []
	data['input']['keys'] = Object.keys(datadummy.data);
	data['range'] = dummy.range;
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
		console.log(question);
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

	const margin = { top: 30, right: 0, bottom: 100, left: 120 }
	const width = 960 - margin.left - margin.right
	const height = 850 - margin.top - margin.bottom
	const gridSize = Math.floor(width / 15.5)
	const legendElementWidth = gridSize*2
	const buckets = 9
	const colors = ["#ff6666","#ff8c66","#ffb366","#ffd966","#ffff66","#d9ff66","#b3ff66","#8cff66","#66ff66"]
	const sectionsNames = ["FOOD", "PRIVACY", "HEALTH","COMFORT","REST","CAREGIVERS","SPORT","ACTIVITIES","SLEEP","FAMILY"]
	const sections = ["A","B","C","D","E","F","G","H","I","J"]
	const times = [0,1,2,3,4,5,6,7,8,9]
	const xLabels = [0,1,2,3,4,5,6]
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
		console.log(p_data);
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
</script>
</body>
</html>

