// Log Console

// Object Instantiation.
	// Pass Console DOM Object.
function LogConsole(terminal) {
	this.terminal = terminal;
	this.length = 0;
}

// Other object Declarations.

// Log Console Object Methods Definition.
LogConsole.prototype.append = function(message) {
	this.terminal.innerHTML = this.terminal.innerHTML + "<li>" + message;
	this.length++;
	this.scroll();
}

LogConsole.prototype.clear = function() {
	this.terminal.innerHTML = "";
	this.length = 0;
}

// Log Console Objections Methods - Special Alerts.
LogConsole.prototype.specialAlert = function(message) {
	this.append(message);
	alert(message);
}

LogConsole.prototype.scroll = function() {
	this.terminal.scrollTop = this.terminal.scrollHeight;
}