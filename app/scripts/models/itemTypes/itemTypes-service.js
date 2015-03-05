app.factory('itemTypesService', function(API, ItemTypes) {
	return {
		get: function() {
			return API
				.post('api.php', {action: 'get-item-types'})
				.then(ItemTypes.apiResponseTransformer);
		}
	};
});