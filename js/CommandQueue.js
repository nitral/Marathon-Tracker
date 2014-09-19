// Command Queue

// Command Queue Data Structure Declaration.
// Constructor
function CommandQueue() {
	this.queue = [];
}

// Command Queue Data Structure Methods Definitions.
CommandQueue.prototype.length = function() {
	return this.queue.length;
}

CommandQueue.prototype.add = function(command) {
	return this.queue.push(command);
}

CommandQueue.prototype.peek = function() {
	if(this.queue.length > 0) {
		return this.queue[0];
	} else {
		return null;
	}
}

CommandQueue.prototype.poll = function() {
	if(this.queue.length > 0) {
		return this.queue.shift();
	} else {
		return null;
	}
}

CommandQueue.prototype.clear = function() {
	this.queue = [];
}

CommandQueue.prototype.contains = function(command) {
	for(var i = 0; i < this.queue.length; i++) {
		if(this.queue[i] == command) {
			return i;
		}
	}
	return null;
}

CommandQueue.prototype.isEmpty = function() {
	if(this.queue.length > 0) {
		return false;
	} else {
		return true;
	}
}

CommandQueue.prototype.remove = function(command) {
	var commandIndex = this.contains(command);
	if(commandIndex != null) {
		queue.splice(commandIndex, 1);
	}
	return commandIndex;
}