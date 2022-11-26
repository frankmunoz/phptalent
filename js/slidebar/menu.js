var sidebarjs = new SidebarJS();
var selectedLink = document.querySelector('#selected');
var selectedImg = document.querySelector('#selected .img');
var selectedLabel = document.querySelector('#selected .label');
var links = document.querySelectorAll('nav a');
var options = document.querySelectorAll('input[name="position"]');

for (var i = 0; i < links.length; i++) {
    links[i].addEventListener('click', elementSelected)
}

function elementSelected(e) {
    selectedLink.setAttribute('href', this.href);
    selectedImg.className = 'img ' + this.text.toLowerCase();
    selectedLabel.innerText = this.text;
    sidebarjs.close();
}
