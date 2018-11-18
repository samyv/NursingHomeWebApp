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
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="grid-container">
	<div class="picture">
		PICTURE
<!--		<img src="https://i.pinimg.com/originals/d0/dd/2c/d0dd2c8bb30ef5281ebb4472f1cc71fa.jpg" />-->
	</div>
	<div class="info">
		Jozef Maes
		<br>
		Leeftijd: 85
		<br>
		Geslacht: Man
		<br>
		Kamer: 105
		<br>
		Allergieën: Geen
		<br>
	</div>
	<div class="back_start"></div>
	<div class="back_buttons">
		<button>RETURN TO HOME</button>
		<br>
		<button>RETURN</button>
	</div>
	<div class="toolbar">TOOLBAR</div>
	<div class="visualisation">
		VISUALISATION
	</div>
	<div class="hint">
		<text rows="4" cols="50">Jozef doesn't like the food, let's talk to him!</text>
	</div>
	<div class="print">
		<input type="submit"></input>
	</div>
</div>
<script>
	let ratings = [
		{date: "2018-10-15", rating: 1183294},
		{date: "2018-10-22", rating: 1058337},
		{date: "2018-11-01", rating: 1088516}
	];

	let x = d3.scaleTime() // d3 scale functions
		.domain(
			d3.extent( // d3 auxilary functions
				ratings.map(r => new Date(Date.parse(r.date)))
				// arrow function
			)
		)
		.range([0, 800]);
	console.log("heelo");
	let y = d3.scaleLinear().domain([0,1200000]).range([560,0]);

	let svg = d3.select('visualisation')
		.append('svg')
		.attr('width',900)
		.attr('height',700);

	let xAxis = d3.axisBottom(x).ticks(5);
	let yAxis = d3.axisLeft(y).ticks(5);

	svg.append('g').attr("transform", "translate(70,580)")
		.attr('class', 'x axis')
		.call(xAxis);

	svg.append('g').attr("transform","translate(70,20)")
		.attr('class', 'y axis')
		.call(yAxis);

	let circle = svg.selectAll("circle").data(ratings, r=>r.date);

	circle.enter().append("circle")
		.attr("cx",(d,i) => 70+x(new Date(Date.parse(d.date))))
		.attr("cy",(d,i) => 20+y(d.rating))
		.attr("r",10)
		.style("fill","steelblue");


	let line = svg.selectAll("line").data(ratings.slice(0,ratings.length-1), r=>r.date);
	line.enter().append("line")
		.attr("x1",50)
		.attr("y1",50)
		.attr("x2",50)
		.attr("y2",100);
</script>
</body>
</html>

