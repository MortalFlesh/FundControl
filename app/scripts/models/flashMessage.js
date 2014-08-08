app.factory('FlashMessage', function(){
	function FlashMessage(message, type) {
		this.message = message;
		this.type = type;
	}

	FlashMessage.prototype.getMessage = function() {
		return this.message;
	};

	FlashMessage.prototype.getType = function() {
		return this.type;
	};

	FlashMessage.build = function(data) {
		return new FlashMessage(data.message, data.type);
	};

	return FlashMessage;
});