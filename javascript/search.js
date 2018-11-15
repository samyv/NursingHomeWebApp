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

function populate()
{
    var database = "<?php echo $result; ?>";
    console.log(database);
    let list = document.getElementById("myUL");
    for (let i = 0 ; i < 10 ; i++)
    {
        let element = document.createElement('li');
        let name = i;
        element.innerHTML = '<a href="#">' + name + '</a>';
        list.appendChild(element);
    }

}
