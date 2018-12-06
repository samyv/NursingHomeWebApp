<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/floor_comparison.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <script src="http://d3js.org/d3.v4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<div class = "grid-container">

    <div class = "title">
        <p>Select floors to compare</p>
    </div>

    <div class = "list">
    </div>

    <div class = "graph">
    </div>
</div>

<script>

    let notificationid = 0;
    let amountOfCategories;

    var floordata=[];
    var list = $(".list");
    var floorAmount = 0+<?php echo $maxFloors;?>;
    for(var i = floorAmount; i >= 1;i--){
        let a = document.createElement('div');
        a.className = "floorbtn container";
        a.innerHTML = "Floor "+i+" <i class=\"fas fa-check\"></i>";
        a.id = i;
        list.append(a);

    };

    $(document).ready(function () {
        $('.floorbtn').click(myFunction);
        $.ajax({
            url: '<?=base_url()?>caregiver/getFloorData',
            dataType: 'json',
            success: function (data) {
                floordata = data[0];
                amountOfCategories = parseInt(data[1]);
                console.log(floordata);
                draw();
            }
        });
    })

    function myFunction(event) {
        var x = event.target.getElementsByTagName('i');
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



    /////////////////////////////////////////////////////////
    //////              D3.JS GRAPH                     /////
    /////////////////////////////////////////////////////////

    /// CONFIG VARIABLES ///
    let text_color = "white";
    let brightness_of_colors = 70; // brightness in percentage
    let color_on = "#66a5ad";
    let color_off = increase_brightness(color_on,brightness_of_colors);


    //// END OF CONFIG ////
    function draw() {
        var collection = [];
        let f = 1;
        while(f <=(floorAmount)) {
            let floorcol = [];
            for (var a = 1; a < amountOfCategories+1; a++) {
                let catcol=[];
                for (let i = 0; i < floordata.length; i++) {
                    if(floordata[i]['questionType']==a &&floordata[i]['floor']==f) {
                        catcol.push({
                            date: new Date(floordata[i]['timestamp']).getTime(),
                            value: parseFloat(floordata[i]['answers'])
                        });
                    }

                }
                floorcol.push(catcol);
            }
            f++;
            collection.push(floorcol);

        }
        console.log(collection);

        var container = d3.select("body").selectAll("div.graph");

        var svgSelection = container.append("svg")
            .attr("width", 50)
            .attr("height", 50);

        var svgWidth = 700, svgHeight = 400;
        var margin = {top: 20, right: 20, bottom: 30, left: 30};
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
            .x(function (d) {
                return x(d.date)
            })
            .y(function (d) {
                return y(d.value)
            })

        let i = 1;
        let j = 1;
        while(i<collection.length) {
            if(collection[i] !== undefined) {
                while (j < collection[i].length) {
                    if (collection[i][j] !== undefined) {
                        x.domain(d3.extent(collection[i][j][0], function (d) {
                            return d.date
                        }));
                        break;
                    }
                    j++
                }
                break;
            }
            i++
        }

        y.domain([0, 5]);

        g.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x))
            .select(".domain")
            .remove();

        var area = d3.area()
            .x(function (d) {
                return x(d.date);
            })
            .y0(height)
            .y1(function (d) {
                return y(d.value);
            });

        for(let f = floorAmount;f>=1;f--) {
            if(collection[f] !== undefined) {
                for (let a = amountOfCategories; a >= 1; a--) {
                    if (collection[i][j] !== undefined) {
                        for (let i = floordata[f].length; i >= 0; i--) {
                            g.append("path")
                                .datum(collection[f][a][i])
                                .attr("fill", "none")
                                .attr("stroke", color_off)
                                .attr("stroke-linejoin", "round")
                                .attr("stroke-linecap", "round")
                                .attr("stroke-width", 3)
                                .attr("d", line)
                                .on("mouseover", mouseEnter)
                                .on("mouseout", mouseLeave);
                        }
                    }
                }
            }
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


        function mouseEnter(data, i) {
            notificationid++;
            let x = event.clientX - width + 150;
            let y = event.clientY - height / 2;
            d3.select(this)
                .attr("stroke-width", 8)
                .attr("stroke", color_on);

            g.append("text")
                .attr("id", "t" + notificationid)
                .attr("x", x)
                .attr("y", y)
                .attr("fill", color_on)
                .text("Category : Date : Score");

        }

        function mouseLeave(data, i) {
            d3.select(this)
                .attr("stroke-width", 3)
                .attr("stroke", color_off);


            d3.select("#t" + notificationid).remove();
        }
    }

    function increase_brightness(hex, percent) // generate brighter versions of the colors
    {
        // strip the leading # if it's there
        hex = hex.replace(/^\s*#|\s*$/g, '');

        // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
        if (hex.length == 3) {
            hex = hex.replace(/(.)/g, '$1$1');
        }

        var r = parseInt(hex.substr(0, 2), 16),
            g = parseInt(hex.substr(2, 2), 16),
            b = parseInt(hex.substr(4, 2), 16);

        return '#' +
            ((0 | (1 << 8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
            ((0 | (1 << 8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
    }
</script>
</body>
</html>
