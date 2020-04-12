function setDisplayNone() {
    let div = document.getElementById("warningBox");
    div.classList.add(".d-none");

}

function scrollToDiv() {
    let buttonID = this.document.activeElement.getAttribute("ID");
    let relevantDiv = elementToView.parentNode;
    buttonID.scrollIntoView();
}
function redirectHome() {
    window.location = "http://0.0.0.0:8000/"

}
