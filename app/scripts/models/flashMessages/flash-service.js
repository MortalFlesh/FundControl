app.factory("flashService", function(API, FlashMessages) {
	return {
		get: function() {
			return API
				.post('api.php', {action: 'get-flash-messages'})
				.then(FlashMessages.apiResponseTransformer);
		}
	};
});