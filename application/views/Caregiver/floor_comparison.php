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
                console.log(amountOfCategories);
                console.log(floorAmount);
                draw(floordata);
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



    // set the dimensions and margins of the graph
 ;

    // set the ranges


    // define the line


    // append the svg obgect to the body of the page
    // appends a 'group' element to 'svg'
    // moves the 'group' element to the top left margin

    /// CONFIG VARIABLES ///
    var margin = {top: 20, right: 20, bottom: 30, left: 50},
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    var x = d3.scaleTime().range([0, width]);
    var y = d3.scaleLinear().range([height, 0]);


    // append the svg obgect to the body of the page
    // appends a 'group' element to 'svg'
    // moves the 'group' element to the top left margin
    var svg = d3.select("body").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");


    //// END OF CONFIG ////
    function draw(data) {
        data.forEach(function(d) {
            d.timestamp = new Date(d.timestamp);
            d.floor = +parseInt(d.floor);
            d.questionType = +d.questionType;
            d.answers = +parseFloat(d.answers);
        });
        console.log(data)
        let valuelines=[];
        let newData=[];
        for(let f = 0; f < floorAmount;f++){
            for(let q = 0; q < amountOfCategories; q++){
                newData[f+q*floorAmount]=[];
                let i = 0;
                data.forEach(function (d) {
                    if (d.floor == (f+1) && d.questionType == (q+1)) {
                        newData[f+q*floorAmount][i]={};
                        newData[f+q*floorAmount][i].timestamp = d.timestamp;
                        newData[f+q*floorAmount][i].answers = +d.answers;
                        valuelines[f + q * floorAmount] = d3.line()
                            .x(function(d) { return x(d.timestamp); })
                            .y(function(d) { return x(d.answers); });
                        i++;
                    }
                })
            }
        }
        console.log(newData[1]);
        console.log(valuelines[1]);

        data.sort(function(a, b){
            return a["timestamp"]-b["timestamp"];
        })

        x.domain(d3.extent(data, function(d) { return d.timestamp; }));
        y.domain([0, 5]);


        svg.append("path")
            .data([newData[1]])
            .attr("class", "line")
            .attr("d", valuelines[1]);


        // Add the X Axis
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x));

        // Add the Y Axis
        svg.append("g")
            .call(d3.axisLeft(y));

    }

</script>
</body>
</html>
