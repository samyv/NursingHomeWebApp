<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Database Searching</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/deleteResident.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/transitions.css">
    <!--    <script src="javascript/search.js"></script>-->

</head>

<body>

<div class="grid-container fade-in	">

    <div class = "h1">
        <h1>Delete Resident</h1>
    </div>

    <div class = "search">
        <input type="text" id="myInput" onkeyup="search()" placeholder="Search.." title="Type in a name">
    </div>

    <div class="table">
        <table id="myTable"></table>
    </div>

    <div class="modal-content" id="information-modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Are you sure you want to delete?</h4>
        </div>



        <div class="modal-footer">
            <input id="yesDelete" class="btn btn-block btn-lg" value="YES" >
            <input id="notDelete" class="btn btn-block btn-lg" value="NO" >

        </div>
    </div>
</div>


<script>
    $(function() {
        populate();
        //init();
    });
    var list,name;

    function search() {
        var input, filter, table, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        list = document.getElementsByTagName('tr');
        for (i = 1; i <= list.length; i++) {
            // console.log(list[i])
            if(list[i] != undefined) {
                name = list[i].getElementsByTagName("td")[1].innerHTML;
                if (name.toUpperCase().indexOf(filter) > -1) {
                    list[i].style.display = "";
                } else {
                    list[i].style.display = "none";
                }
            }
        }
    }

    function populate() {
        var database = "";
        database = <?php echo json_encode($listCar)?>;
        var table = document.getElementById("myTable");
        var tbody = document.createElement("tbody");
        var row = document.createElement('tr');
        var id = document.createElement('th');
        // id.style.display = "block";
        id.innerHTML = "ID";
        row.appendChild(id);

        var col1 = document.createElement('th');
        col1.innerHTML = "Name";
        row.appendChild(col1)
        var col2 = document.createElement('th');
        col2.innerHTML = "Floor";
        row.appendChild(col2)
        var col3 = document.createElement('th');
        col3.innerHTML = ""; //or nothing
        row.appendChild(col3)
        tbody.appendChild(row)
        var elements = [];
        for (var i = 0 ; i < database.length ; i++)
        {
            var element = getElements(database[i]);
            elements.push(element);

            var row = document.createElement('tr');

            var id = document.createElement('td');
            id.innerHTML = element.id;
            // id.style.display = "block"
            row.appendChild(id);
            var col1 = document.createElement('td');
            col1.innerHTML = element.name
            row.appendChild(col1)
            var col2 = document.createElement('td');
            col2.innerHTML = element.floor;
            row.appendChild(col2)
            var col3 = document.createElement('td');
            col3.innerHTML = "<button class='delete'><a href='#'class='delete' id='CIModal' >DELETE</a></button>\n";
            let childs = col3.children
            let a = childs[0]
            let aa = childs[0].children[0]
            a.setAttribute('value', element.id)
            aa.setAttribute('value',element.id)
            row.appendChild(col3)
            tbody.appendChild(row);
        }
        table.appendChild(tbody)
    }

    function getElements(db_element) {
        var element = {}
        element.id = db_element['residentID'];
        element.name = db_element['firstname'] +" " + db_element['lastname'];
        element.floor = db_element['floor'];
        return element;
    }



    //Create global variable
    var IDtoDelete = "global";

    //On click of yes delete the caregiver with global ID
    //update table??

    $(document).ready(function () {
        console.log("here");
        $('.delete').click(function(){
            $('#information-modal-content').fadeIn('fast');

            //not correct! but get the id of the delete button and change the global variable

            IDtoDelete = this.getAttribute('value');
            //console.log(IDtoDelete)



        });

        //use this for no button
        $('#closemodal').click(function () {
            $('#information-modal-content').fadeOut('fast');
        });
        $('#notDelete').click(function () {
            $('#information-modal-content').fadeOut('fast');
        });

        $('#yesDelete').click(deleteResident())

    });


    function deleteResident() {
        console.log(IDtoDelete)


    }

</script>

</body>
</html>