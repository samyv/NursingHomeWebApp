<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>{page_title}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/deleteCaregiver.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
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
            <input id="notDelete" class="btn btn-block btn-lg" value="NO" readonly>

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
            col3.innerHTML = "<button><a href='#'class='delete' id='CIModal' >DELETE</a></button>\n";
            let childs = col3.children
            let aa = childs[0].children[0]
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
    $IDtoDelete = "global";

    //On click of yes delete the caregiver with global ID
    //update table??

    $(document).ready(function () {
        $('.delete').click(function(){
            //$('#information-modal-content').fadeIn('fast');

            $IDtoDelete = this.getAttribute('value');
            Confirm('Delete resident?', 'Are you sure you want to delete this resident?', 'Yes', 'Cancel', $IDtoDelete);

            //console.log(IDtoDelete)



        });

        //use this for no button
        $('#closemodal').click(function () {
            $('#information-modal-content').fadeOut('fast');
        });
        $('#notDelete').click(function () {
            $('#information-modal-content').fadeOut('fast');
        });

        $('#yesDelete').click(deleteResident)

    });


    function deleteResident() {
        console.log(IDtoDelete)

    }

    function Confirm(title, msg, $true, $false, $id) { /*change*/
        var $content = "<div class='dialog-ovelay'>" +
            "<div class='dialog'><header>" +
            " <h3> " + title + " </h3> " +
            "<i class='fa fa-close'></i>" +
            "</header>" +
            "<div class='dialog-msg'>" +
            " <p> " + msg + " </p> " +
            "</div>" +
            "<footer>" +
            "<div class='controls'>" +
            " <button class='button button-danger doAction'>" + $true + "</button> " +
            " <button class='button button-default cancelAction'>" + $false + "</button> " +
            "</div>" +
            "</footer>" +
            "</div>" +
            "</div>";
        $('body').prepend($content);
        $flag = false;
        $('.doAction').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
                console.log($id);

                $.ajax({
                    url: '<?=base_url()?>Caregiver/ResidentDelete',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'idResident': $id
                    },
                    success() {

                    }
                });
            });
        });

        $('.cancelAction, .fa-close').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });
        });
    };

</script>

</body>
</html>