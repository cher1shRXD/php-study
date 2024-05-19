var x = screen.width;
var y = screen.height;
if(x >= y || y / x <= 0.7) {
    document.querySelector("html").style.fontSize = "6px";
    document.getElementById("screen").style.width = 4 / 7 * y + "px";
    document.getElementById("screen").style.height = "95%";
    document.getElementById("screen").style.bottom = "2.5%";
    document.getElementById("screen").style.border = "1px gray solid";
    document.getElementById("screen").style.boxShadow = "5px 5px 15px #ddd";
}else if (y / x <= 1.8) {
    document.querySelector("html").style.fontSize = "7px";
    document.getElementById("screen").style.width = 4 / 7 * y + "px";
}
