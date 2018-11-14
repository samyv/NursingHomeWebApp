

document.getElementById("loginButton").addEventListener('click',showButtons);

function showButtons() {
    const b = document.getElementsByClassName("ResidentButton");
    let i;
    for(i=0;i<b.length;i++){
        b[i].style.display = "block";
    }
}