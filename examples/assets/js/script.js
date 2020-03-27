function setDisplayNone() {
    let div = document.getElementById("warningBox");
     div.classList.remove("warning-msg");
     div.classList.add("warning-msg-hide");
}

function redirectHome() {
    window.location = "http://0.0.0.0:8000/"

}