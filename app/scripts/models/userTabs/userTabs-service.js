app.factory("userTabsService", function(API, UserTabs) {
	return {
		get: function(tabName) {
			return API
				.post('api.php', {action: 'get-user-tabs', data: {tabName: tabName}})
				.then(UserTabs.apiResponseTransformer);
		}
	};
});