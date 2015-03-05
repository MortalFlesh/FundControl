app.factory('gainTypesService', function(API, GainTypes) {
	return {
		get: function() {
			return API
				.post('api.php', {action: 'get-gain-types'})
				.then(GainTypes.apiResponseTransformer);
		}
	};
});