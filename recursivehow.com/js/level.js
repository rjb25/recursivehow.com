function levels(amount) {
	for(levelNumber = 1; levelNumber <= amount; levelNumber++){
		var form = document.getElementById("levelForm"); 
		var button = document.createElement("button");
		button.setAttribute("class", "navigationDropdownLink");
		button.setAttribute("type", "submit");
		button.setAttribute("name", "level");
		button.setAttribute("value", "".concat(levelNumber));
		var label = document.createTextNode("Level ".concat(levelNumber));
		button.appendChild(label);
		form.appendChild(button);
	}
}
