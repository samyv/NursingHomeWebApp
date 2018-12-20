<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/buildingView.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="assets/css/transitions.css">
</head>

<body>
<div class = "grid-container fade-in">
<!-- TODO: Add the correct links            -->
<!-- TODO: Get the floors from the database -->

	<div class = "title">
		<p>
            <?php
            echo ($this->lang->line('title buidlingView'));?>
        </p>
	</div>
		<div class="list"></div>
</div>
</body>

<script>
	var list = $(".list");
	var floorAmount = 0+<?php echo $maxFloors;?>;
	for(var i = floorAmount; i >= 1;i--){
		let a = document.createElement('a');
		a.className = "listRow"+i;
		a.innerText = "<?php
            echo ($this->lang->line('floor'));?>"
            + " " + i;
		a.href = "floorView?"+"id="+a.innerText.slice(-1);
		a.addEventListener("click",function(e) {
			sessionStorage.setItem("floorSelected",this.innerText.slice(-1))
		})
		list.append(a);

	};

</script>
</html>
