window.onload = populate;

function search() {
	var input, filter, ul, li, a, i;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	ul = document.getElementById("myUL");
	li = ul.getElementsByTagName("li");
	for (i = 0; i < li.length; i++) {
		a = li[i].getElementsByTagName("a")[0];
		if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "";
		} else {
			li[i].style.display = "none";
		}
	}
}

var database;
var list;

function populate()
{
	console.log("hello")

	// database = <?php echo json_encode($listCar)?>
	list = document.getElementById("myUL");

	for (var i = 0 ; i < 10 ; i++)
	{
		var element = document.createElement('li');
		var name = i;
		element.innerHTML = '<a href="#">' + name + '</a>';
		list.appendChild(element);
	}
}
