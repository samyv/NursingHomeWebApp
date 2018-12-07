<!DOCTYPE html>
<html>
<head>
    <title>Floor comparison</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/floor_comparison.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <script src="http://d3js.org/d3.v4.js"></script>
	<link rel="stylesheet" href="assets/css/transitions.css">
</head>

<body>
<div class = "grid-container fade-in">

    <div class = "title">
        <p>Select floors to compare</p>
    </div>

    <div class = "list">
        <div class="floorbtn container">Floor 5
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 4
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 3
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 2
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 1
            <i class="fas fa-check"></i>
        </div>
    </div>

    <div class = "graph">
    </div>
</div>

<script>

    $(document).ready(function () {
        $('.floorbtn').click(myFunction)
    })

    function myFunction(event) {
        var x = event.target.getElementsByTagName('i');
        console.log(x);
        if (x.length == [])
        {
            clickIcon(event);
            return;
        }
        if (x[0].style.display == "inline-grid") {
            x[0].style.display = "none";
        } else {
            x[0].style.display = "inline-grid";
        }
    }

    function clickIcon(event) {
        var x = event.target;
        if (x.style.display == "inline-grid") {
            x.style.display = "none";
        } else {
            x.style.display = "inline-grid";
        }
    }
</script>
</body>
</html>

<script>
    /////////////////////////////////////////////////////////
    //////              D3.JS GRAPH                     /////
    /////////////////////////////////////////////////////////


    /// CONFIG VARIABLES ///
    let text_color = "white";
    let brightness_of_colors = 70; // brightness in percentage
    let color_on = increase_brightness("#66a5ad",-50);
    let color_off = increase_brightness(color_on,brightness_of_colors);
    let notificationid = 0;
    let amountOfFloors = 11;
    //// END OF CONFIG ////

    var collection = [];
    for (var a = 0 ; a < amountOfFloors ; a++)
    {
        let data = [];
        var offset = a;


        for (let i = 0 ; i < 20 ; i++) {
            // calculate offset
            if (a === 0)
            {
                offset = 0;
            }
            else
            {
                let data = collection[a-1];
                offset = data[i].value;
            }
            // push to array
            data.push(
                {
                    date: new Date().getUTCDate() + i*1000*60*60*24, // add one day for each data point
                    value: 2.5 + 0.5*Math.sin(i/3 + a) + 0.1*Math.sin(i/0.6 + a) + 0.9*Math.sin(i/4 - a/2) + 0.5*Math.sin(i/16 + a) + 0.5*Math.sin(i/19)
                });
        }
        collection.push(data);
    }

    var container = d3.select("body").selectAll("div.graph");

    var svgSelection = container.append("svg")
                                    .attr("width", 50)
                                    .attr("height", 50);

    var svgWidth = 700, svgHeight = 400;
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
    x.domain(d3.extent(collection[0], function(d) { return d.date }));

    let max = getMaximum(collection[amountOfFloors-1]);
    y.domain([0, 5]);

    g.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x))
        .select(".domain")
        .remove();

    var area = d3.area()
        .x(function(d) { return x(d.date); })
        .y0(height)
        .y1(function(d) { return y(d.value); });

    for ( let i = amountOfFloors-1 ; i >= 0 ; i--)
    {
        g.append("path")
            .datum(collection[i])
            .attr("fill", "none")
            .attr("stroke", color_off)
            .attr("stroke-linejoin", "round")
            .attr("stroke-linecap", "round")
            .attr("stroke-width", 3)
            .attr("d", line)
            .on("mouseover", mouseEnter)
            .on("mouseout", mouseLeave);


    }

    g.append("g")
        .call(d3.axisLeft(y))
        .append("text")
        .attr("fill", text_color)
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "0.71em")
        .attr("text-anchor", "end")
        .text("Value");




    function mouseEnter(data,i)
    {
        notificationid++;
        let x = event.clientX-width + 200;
        let y = event.clientY-height/2;
        d3.select(this)
            .transition()
            .attr("stroke-width", 8)
            .attr("stroke",color_on);

            g.append("text")
                .attr("id","t" +notificationid)
                .attr("x",x)
                .attr("y",y)
                .attr("fill",color_on)
                .text("Category : Date : Score");

    }

    function mouseLeave(data,i)
    {
        d3.select(this)
            .transition()
            .attr("stroke-width", 3)
            .attr("stroke",color_off);


        d3.select("#t" +notificationid).remove();
    }




    function getMaximum(collection)
    {
        // calculate the maximum of a custom formatted data array
        let array = [];
        for (let i = 0 ; i < collection.length ; i++)
        {
            let val = collection[i].value;
            array.push(val);
        }
        return 1.1 * Math.ceil(Math.max(...array)); // the ... notation is needed here
    }

    function increase_brightness(hex, percent) // generate brighter versions of the colors
    {
        // strip the leading # if it's there
        hex = hex.replace(/^\s*#|\s*$/g, '');

        // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
        if(hex.length == 3){
            hex = hex.replace(/(.)/g, '$1$1');
        }

        var r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);

        return '#' +
            ((0|(1<<8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
            ((0|(1<<8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
            ((0|(1<<8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
    }

</script>
