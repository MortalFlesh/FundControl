app.factory("itemsService", function(API, Items) {
	return {
		get: function() {
			return API
				.post('api.php', {action: 'get-items'})
				.then(Items.apiResponseTransformer);
		}
	};
});