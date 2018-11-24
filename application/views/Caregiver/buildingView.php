<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/buildingView.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>

<body>
<div class = "grid-container">
<!-- TODO: Add the correct links            -->
<!-- TODO: Get the floors from the database -->

    <div class = "title">
        <p>Please select the desired floor</p>
    </div>

    <div class = "list" id="list">
    </div>

    <div class = "footer">
        <p>Footer goes here</p>
    </div>

</div>
</body>
<script>
	var list = document.getElementById('list');
	var floorAmount = 0+<?php echo $maxFloors;?>;
	for(var i = floorAmount; i >= 1;i--){
		let a = document.createElement('a');
		a.className = "listRow"+i;
		a.href='floorView'
		a.innerText = "Floor "+i;
		a.addEventListener("click",function(e) {
			sessionStorage.setItem("floorSelected",this.innerText.slice(-1))
		})
		list.appendChild(a);
	}


</script>
</html>
