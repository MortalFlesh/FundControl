app.factory("gainsService", function(API, Gains) {
	return {
		get: function() {
			return API
				.post('api.php', {action: 'get-gains'})
				.then(Gains.apiResponseTransformer);
		}
	};
});