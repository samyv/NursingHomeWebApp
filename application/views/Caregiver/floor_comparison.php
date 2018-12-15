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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/2.25.6/d3-legend.js"></script>
</head>

<body>
<div class = "grid-container fade-in">

    <div class = "title">
        <p><?php echo($this->lang->line('title floor compare'));?></p>
    </div>

    <div class = "list">
    </div>

    <div class="tab categories">
        <?php
        $i=0;
        foreach($categories as $category){ ?>
            <button class="tablinks category<?php echo $i?>" id="<?php echo $category['sectionType']?>" onclick="openTab(event, '<?php echo $category["sectionType"]?>')"><?php echo $category['sectionType']?></button>
            <?php $i++;} ?>
    </div>

    <div class="tab date">
        <button class="tablinksdate active year" id="year" onclick="openDateTab(event, 'year')"><?php echo($this->lang->line('last year'));?></button>
        <button class="tablinksdate month" id="month" onclick="openDateTab(event, 'month')"><?php echo($this->lang->line('last month'));?></button>
        <button class="tablinksdate week" id="week" onclick="openDateTab(event, 'week')"><?php echo($this->lang->line('last week'));?></button>
    </div>


    <div class="graph">
    <?php
        $i=0;
        foreach($categories as $category){ ?>
        <div class="tabcontent category<?php echo $i?>year" id="<?php echo $category['sectionType']?>year"></div>
        <div class="tabcontent category<?php echo $i?>month" id="<?php echo $category['sectionType']?>month"></div>
        <div class="tabcontent category<?php echo $i?>week" id="<?php echo $category['sectionType']?>week"></div>
    <?php $i++;} ?>
    </div>
</div>

<script>


    window.addEventListener("resize", redraw);

    function openTab(evt, category) {
        // Declare all variables
        var i, tabcontent, tablinks, time;

        let times = document.getElementsByClassName("tablinksdate active");
        time = times[0].id;
        console.log(time);


        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(category+time).style.display = "block";
        evt.currentTarget.className += " active";
    }
    function openDateTab(evt, time) {
        // Declare all variables
        var i, tabcontent, tablinks, category;

        let categories = document.getElementsByClassName("tablinks active");
        category = categories[0].id;
        console.log(category);

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinksdate");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(category+time).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function redraw(){
        let times = document.getElementsByClassName("tablinksdate active");
        time = times[0].id;
        draw(time);
    }
    let notificationid = 0;
    let amountOfCategories;

    var floordata=[];
    var list = $(".list");
    var floorAmount = 0+<?php echo $maxFloors;?>;
    for(var i = floorAmount; i >= 1;i--){
        let a = document.createElement('div');
        a.className = "floorbtn container";
        a.innerHTML = "<?php echo($this->lang->line('floor'));?>" + " " +i+" <i class=\"fas fa-check\"></i>";
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
                draw("year")
                document.getElementsByClassName("tablinks")[0].click();
            }
        });

        $.ajax({
            url: '<?=base_url()?>caregiver/getFloorDataLastWeek',
            dataType: 'json',
            success: function (data) {
                floordata = data[0];
                draw("week")
                amountOfCategories = parseInt(data[1]);
            }
        });

        $.ajax({
            url: '<?=base_url()?>caregiver/getFloorDataLastMonth',
            dataType: 'json',
            success: function (data) {
                floordata = data[0];
                draw("month")
                amountOfCategories = parseInt(data[1]);
            }
        });


    });

    function myFunction(event) {
        var x = event.target.getElementsByTagName('i');
        if (x.length == [])
        {
            clickIcon(event);
            return;
        }
        if (x[0].style.display == "inline-grid") {
            x[0].style.display = "none";
            hideLines(event);
        } else {
            x[0].style.display = "inline-grid";
            showLines(event);
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


    function showLines(event) {
        $x = '.floor'+$(event.target).attr("id");
        $lines = $($x);
        $lines.attr("display","inline");
    }

    function hideLines(event) {
        $x = '.floor'+$(event.target).attr("id");
        $lines = $($x);
        console.log($lines);
        $lines.attr("display","none");
    }




    /// CONFIG VARIABLES ///




    // append the svg obgect to the body of the page
    // appends a 'group' element to 'svg'
    // moves the 'group' element to the top left margin



    //// END OF CONFIG ////
    function draw(time) {


        var div = document.getElementsByClassName("graph")[0];
        var margin = {top: 20, right: 20, bottom: 30, left: 50},
            width = div.clientWidth - margin.left - margin.right,
            height = div.clientHeight - margin.top - margin.bottom;

        var x = d3.scaleTime().range([0, width]);
        var y = d3.scaleLinear().range([height, 0]);
        for (q = 0; q < amountOfCategories; q++) {

            $svg = $(".tabcontent.category"+q+time).children()
            if($svg.length !== 0){
                $svg.remove()
            }



            var svg = d3.select("body").select("div.graph").select("div.tabcontent.category"+q+time).append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");


        floordata.forEach(function (d) {
            d.timestamp = new Date(d.timestamp);
            d.floor = +parseInt(d.floor);
            d.questionType = +d.questionType;
            d.answers = +d.answers;
        });


        let valuelines = [];
        let newData = [];
        for (let f = 0; f < floorAmount; f++) {
                newData[f + q * floorAmount] = [];
                let i = 0;
                floordata.forEach(function (d) {
                    if (d.floor == (f + 1) && d.questionType == (q + 1)) {
                        newData[f + q * floorAmount][i] = {};
                        newData[f + q * floorAmount][i].timestamp = d.timestamp;
                        newData[f + q * floorAmount][i].answers = +d.answers;
                        i++;
                    }
                })

        }


        var valueline = d3.line()
            .x(function (d) {
                return x(d.timestamp);
            })
            .y(function (d) {
                return y(d.answers);
            });

        floordata.sort(function (a, b) {
            return a["timestamp"] - b["timestamp"];
        })

        x.domain(d3.extent(floordata, function (d) {
            return d.timestamp;
        }));
        y.domain([1, 5]);

        var colorArray = ['#FF6633', '#00B3E6',
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
            '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
            '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
            '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
            '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
            '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
            '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

        const sectionsNames = ["Privacy", "Eten en maaltijden", "Veiligheid", "Zich prettig voelen", "Autonomie", "Respect", "Reageren door medewerkers op vragen", "Een band voelen met wie hier werkt", "Keuze aan activiteiten", "Persoonlijke omgang", " Informatie vanuit het woonzorgcentrum"];


        for (let f = 0; f < floorAmount; f++) {

                svg.append("path")
                    .data([newData[f + q * floorAmount]])
                    .attr("class", "line" + " floor" + (f + 1))
                    .attr("d", valueline)
                    .attr("id", sectionsNames[q]+time)
                    .attr("stroke", colorArray[f])
                    .attr("data-legend","floor " + (f+1));

                $i = $("#"+(f+1)).children();
                if($i.first().css("display") === "none"){
                    svg.select(".floor"+(f+1)).attr("display", "none");
                }

            svg.append("svg:rect")
                .attr("x", width - 100)
                .attr("y", margin.top + f*50)
                .attr("stroke", colorArray[f])
                .attr("fill",colorArray[f])
                .attr("height", 2)
                .attr("stroke-width", "5px")
                .attr("width", 40)
                .attr("opacity",0.3);

            svg.append("svg:text")
                .attr("x", width-100+50)
                .attr("y", margin.top + 5 + f*50)
                .text("Floor "+ (f+1));

        }

        // Add the X Axis
        svg.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x));

        // Add the Y Axis
        svg.append("g")
            .call(d3.axisLeft(y));


    }


    }

</script>
</body>
</html>
