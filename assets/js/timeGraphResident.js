function drawTimeResident(data) {


    data.forEach(function (d) {
        d.timestamp = new Date(d.timestamp);
        d.total = +d.total;
    });

    var bisectDate = d3.bisector(function(d) { return d.timestamp; }).left;

    var div = document.getElementsByClassName("timeChart")[0];
    var margin = {top: 20, right: 20, bottom: 30, left: 50},
        width = div.clientWidth - margin.left - margin.right,
        height = div.clientHeight - margin.top - margin.bottom;

    var x = d3.scaleTime()
        .domain(d3.extent(data, function (d) {
            return d.timestamp;
        }))
        .range([0, width]);
    var y = d3.scaleLinear()
        .domain([0, d3.max(data, function (d, i) {
            return d.total+10
        })])
        .range([height, 0]);

    let xAxis = d3.axisBottom(x)
        .ticks(d3.max(data, function (d, i) {
            return (2 + i)
        }));


    let yAxis = d3.axisLeft(y)
        .ticks(4);

    var svg = d3.select("body").select("div.visualisation").select("div.timeChart").append("svg")
        .attr("id", "timechart")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");


    var valueline = d3.line()
        .x(function (d) {
            return x(d.timestamp);
        })
        .y(function (d) {
            return y(d.total);
        });

    data.sort(function (a, b) {
        return a["timestamp"] - b["timestamp"];
    })


    svg.append("path")
        .datum(data)
        .attr("class", "line")
        .attr("d", valueline)
        .attr("id","myPath")
        .attr("stroke", '#66a5ad')
        .attr("stroke-width", "5px")
        .attr("fill", "none")

    // Add the X Axis
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    // Add the Y Axis
    svg.append("g")
        .call(yAxis);

    var focus = svg.append("g")
        .attr("class", "focus")
        .style("display", "none");

    focus.append("circle")
        .attr("r", 4.5);

    focus.append("text")
        .attr("x", -15)
        .attr("dy", "-0.5em");

    svg.append("rect")
        .attr("class", "overlay")
        .attr("width", width)
        .attr("height", height)
        .on("mouseover", function() { focus.style("display", null); })
        .on("mouseout", function() { focus.style("display", "none"); })
        .on("mousemove", mousemove);


    function mousemove() {
        var x0 = x.invert(d3.mouse(this)[0]),
            i = bisectDate(data, x0, 1),
            d0 = data[i - 1],
            d1 = data[i],
            d = x0 - d0.timestamp > d1.timestamp - x0 ? d1 : d0;
        focus.attr("transform", "translate(" + x(d.timestamp) + "," + y(d.total) + ")");
        focus.select("text").text(d.total);
    }


}