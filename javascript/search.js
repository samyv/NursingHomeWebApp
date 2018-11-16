function init() {
	console.log("init")
	$('myTable tbody tr td').click(function (event) {
		console.log("hello");
	})
	$("#hidden").hover(function () {
		$(this).css("color","black");
	})
}
