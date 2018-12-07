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

    let dataTest = [
        {floor: "4", questionType: "1", timestamp: 1512573637000, answers: "3.5"},
        {floor: "4", questionType: "1", timestamp: 1513503908000, answers: "3"},
        {floor: "4", questionType: "1", timestamp: 1513717159000, answers: "1.5"},
                ];
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
                console.log(data[0]);
                console.log(dataTest);
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
            d.answers = +d.answers;
        });

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
                        i++;
                    }
                })
            }
        }
        console.log(newData);

        var valueline = d3.line()
            .x(function(d) { return x(d.timestamp); })
            .y(function(d) { return y(d.answers); });

        data.sort(function(a, b){
            return a["timestamp"]-b["timestamp"];
        })

        x.domain(d3.extent(data, function(d) { return d.timestamp; }));
        y.domain([0,5]);

        var colorArray = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

        const sectionsNames = ["Privacy", "Eten en maaltijden", "Veiligheid","Zich prettig voelen","Autonomie","Respect","Reageren door medewerkers op vragen","Een band voelen met wie hier werkt","Keuze aan activiteiten","Persoonlijke omgang"," Informatie vanuit het woonzorgcentrum"];


        for (let f = 0; f<floorAmount;f++) {
            for(let q = 0; q < amountOfCategories; q++) {
                console.log(newData[f+q*floorAmount]);
                svg.append("path")
                    .data([newData[f+q*floorAmount]])
                    .attr("class", "line")
                    .attr("d", valueline)
                    .attr("style", "stroke: " + colorArray[f])
                    .attr("id", sectionsNames[q])
                    .attr("style", "opacity: 0.6")
                    .attr("stroke", colorArray[f]);
            }
        }


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
