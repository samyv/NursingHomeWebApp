<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>{page_title}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/deleteResident.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/transitions.css">
    <!--    <script src="javascript/search.js"></script>-->

</head>

<body>

<div class="grid-container fade-in	">

    <div class = "h1">
        <h1><?php echo ($this->lang->line('title delete resident'));?></h1>
    </div>

    <div class = "search">
        <input type="text" id="myInput"  class= "form-control" onkeyup="search()" placeholder="<?php echo ($this->lang->line('search'));?>" title="Type in a name">
    </div>

    <div class="table-container">
        <table class="table" id="myTable"></table>
    </div>
</div>


<div class='dialog-ovelay' role="alert">
    <div class='dialog'>
        <header>
            <h3><?php echo ($this->lang->line('title delete resident'));?></h3>
            <i class='fa fa-close'></i>
        </header>
        <div class='dialog-msg'>
            <p><?php echo ($this->lang->line('text delete resident'));?></p>
        </div>
        <footer>
            <div class='controls'>
                <button class='button button-danger doAction'><?php echo ($this->lang->line('yes'));?></button>
                <button class='button button-default cancelAction'><?php echo ($this->lang->line('cancel'));?></button>
            </div>
        </footer>
    </div>
</div>


<script>
    $(function() {
        populate();
        //init();
    });
    var list,name, floor, room;

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
                floor = list[i].getElementsByTagName("td")[2].innerHTML;
                room = list[i].getElementsByTagName("td")[3].innerHTML;

                if (name.toUpperCase().indexOf(filter) > -1 || floor.indexOf(filter) > -1 || room.indexOf(filter) > -1) {
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
        var thead = document.createElement("thead");
        var tbody = document.createElement("tbody");
        var row = document.createElement('tr');
        var id = document.createElement('th');
        // id.style.display = "block";
        id.innerHTML = "ID";
        row.appendChild(id);

        var col1 = document.createElement('th');
        col1.innerHTML = "<?php echo ($this->lang->line('name'));?>";
        row.appendChild(col1)
        var col2 = document.createElement('th');
        col2.innerHTML = "<?php echo ($this->lang->line('floor'));?>";
        row.appendChild(col2)
        var col3 = document.createElement('th');
        col3.innerHTML = "<?php echo ($this->lang->line('room'));?>"; //or nothing
        row.appendChild(col3)
        var col4 = document.createElement('th');
        col4.innerHTML = ""; //or nothing
        row.appendChild(col4);
        thead.appendChild(row);
        var elements = [];
        for (var i = 0 ; i < database.length ; i++)
        {
            var element = getElements(database[i]);
            elements.push(element);

            var row = document.createElement('tr');

            var id = document.createElement('td');
            id.innerHTML = element.id;
            id.id = element.id;
            // id.style.display = "block"
            row.appendChild(id);
            var col1 = document.createElement('td');
            col1.innerHTML = element.name
            row.appendChild(col1)
            var col2 = document.createElement('td');
            col2.innerHTML = element.floor;
            row.appendChild(col2)
            var col3 = document.createElement('td');
            col3.innerHTML = element.room;
            row.appendChild(col3)
            var col4 = document.createElement('td');
            col4.innerHTML = "<a href='#'class='delete' ><img src='assets/images/delete_icon.jpg' style='width:20px;height:20px;'></a>\n";
            let childs = col4.children
            let aa = childs[0].children[0]
            aa.setAttribute('value',element.id)
            row.appendChild(col4)
            tbody.appendChild(row);
        }
        table.appendChild(thead)
        table.appendChild(tbody)
    }

    function getElements(db_element) {
        var element = {}
        element.id = db_element['residentID'];
        element.name = db_element['firstname'] +" " + db_element['lastname'];
        element.floor = db_element['floor'];
        element.room = db_element['room'];
        return element;
    }



    //Create global variable
    $IDtoDelete = "";

    //On click of yes delete the caregiver with global ID
    //update table??


    $(document).ready(function () {
        $('.delete').click(function(event){
            //$('#information-modal-content').fadeIn('fast');
            $tr = $(event.target).parents("tr");
            $td = $(event.target).parent().parent().prev().prev().prev().prev();
            $IDtoDelete = $td.attr("id");
            Confirm($IDtoDelete,$tr);

            //not correct! but get the id of the delete button and change the global variable


        });

    });

    function Confirm($IDtoDelete, $tr) { /*change*/
        $('.dialog-ovelay').css("display","block");
        $('.doAction').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).parents('.dialog-ovelay').css("display","none");
                $.ajax({
                    url: window.origin+'/a18ux02/Caregiver/ResidentDelete',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'idResident': $IDtoDelete
                    },
                    success() {

                    }
                });
                $tr.remove();
                //$note.parent().remove();
            });
        });

        $('.cancelAction, .fa-close').click(function () {
            $('.dialog-ovelay').fadeOut(500, function () {
                $('.dialog-ovelay').css("display","none");
            });
        });
    };

</script>

</body>
</html>