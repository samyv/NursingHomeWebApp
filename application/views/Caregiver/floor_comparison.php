<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/floor_comparison.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="http://d3js.org/d3.v4.js"></script>
</head>

<body>
<div class = "grid-container">
    <!-- TODO: Add the correct links            -->

    <div class = "title">
        <p>Select floors to compare</p>
    </div>

    <div class = "list">
        <label class="container">Floor 5
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <label class="container">Floor 4
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <label class="container">Floor 3
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <label class="container">Floor 2
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
        <label class="container">Floor 1
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>
    </div>

    <div class = "graph">
    </div>

</div>
</body>
</html>

<script>
    /////////////////////////////////////////////////////////
    //////              D3.JS GRAPH                     /////
    /////////////////////////////////////////////////////////
    var data = [];
    let text_color = "white";
    for (let i = 0 ; i < 100 ; i++) {
        data.push(
            {
                date: new Date(i),
                value: Math.sin(i/13.0)
            });
    }

    var container = d3.select("body").selectAll("div.graph");

    var svgSelection = container.append("svg")
                                    .attr("width", 50)
                                    .attr("height", 50);

    var svgWidth = 600, svgHeight = 400;
    var margin = { top: 20, right: 20, bottom: 30, left: 30 };
    var width = svgWidth - margin.left - margin.right;
    var height = svgHeight - margin.top - margin.bottom;

    let svg = container.append("svg")
        .attr("width", svgWidth)
        .attr("height", svgHeight);

    var g = svg.append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")"
        );

    var x = d3.scaleTime().rangeRound([0, width]);
    var y = d3.scaleLinear().rangeRound([height, 0]);

    var line = d3.line()
        .x(function(d) { return x(d.date)})
        .y(function(d) { return y(d.value)})
    x.domain(d3.extent(data, function(d) { return d.date }));
    y.domain(d3.extent(data, function(d) { return d.value }));

    g.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .select(".domain")
        .remove();

    g.append("g")
        .call(d3.axisLeft(y))
        .append("text")
        .attr("fill", text_color)
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "0.71em")
        .attr("text-anchor", "end")
        .text("Value");

    g.append("path")
        .datum(data)
        .attr("fill", "none")
        .attr("stroke", text_color)
        .attr("stroke-linejoin", "round")
        .attr("stroke-linecap", "round")
        .attr("stroke-width", 1.5)
        .attr("d", line);
</script>