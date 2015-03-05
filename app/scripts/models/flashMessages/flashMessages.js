app.factory('FlashMessages', function(FlashMessage){
	function FlashMessages(flashMessages) {
		this.flashMessages = flashMessages;
	}

	FlashMessages.prototype.getFlashMessages = function(){
		return this.flashMessages;
	};

	FlashMessages.build = function(data) {
		var flashMessages = [];

		angular.forEach(data, function(data, key){
			var Message = FlashMessage.build({message:data.message, type:data.type});
			flashMessages.push(Message);
		});

		return new FlashMessages(flashMessages);
	};

	FlashMessages.apiResponseTransformer = function(responseData) {
		return FlashMessages.build(responseData);
	};

	return FlashMessages;
});