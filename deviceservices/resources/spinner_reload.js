function submitActivate() {
	var button = document.getElementById('btn-continue');
	if (!button.disabled) {
		/*button.disabled = true;
		button.className = button.className + " disabled";*/
		var spinner = document.getElementById("submitted-spinner");
		spinner.style.display = "block";
		startAnimatingSpinner();
		var activationForm = document.forms['auth_form'];
		activationForm.submit();
	}
}

function animateSpinner() {
	var spinnerDiv = document.getElementById('submitted-spinner');
	var currentClassName = spinnerDiv.className;
	var spinnerPosRegexp = new RegExp(/pos([\d]+)/);
	var newClassNames;
	var matchRegexp = currentClassName.match(spinnerPosRegexp);
	if (matchRegexp) {
		var currPosClass = currentClassName.match(spinnerPosRegexp)[0];
		var oldSpinnerPos = RegExp.$1;
		newClassNames = currentClassName.replace(new RegExp(currPosClass), "").trim().split(/[\s]+/);
        newClassNames.push("pos" + (parseInt(oldSpinnerPos, 10)+1)%12);
        newClassNames = newClassNames.join(" ");
	} else {
        newClassNames = currentClassName + " pos0";
    }
    spinnerDiv.className = newClassNames;
    window._spinnerTO = setTimeout(animateSpinner, 100);
}

function startAnimatingSpinner() {
    window._spinnerTO = setTimeout(animateSpinner, 100);
}

function stopAnimatingSpinner() {
    clearTimeout(window._spinnerTO);
}