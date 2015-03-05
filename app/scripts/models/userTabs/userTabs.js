app.factory('UserTabs', function(UserTabMonth, UserTabAll, UserTabByTypes){
	function UserTabs() {
	}

	UserTabs.apiResponseTransformer = function(response) {
		switch(response.tabName) {
			case 'month': return UserTabMonth.build(response.tabData);
			case 'all': return UserTabAll.build(response.tabData);
			case 'byTypes': return UserTabByTypes.build(response.tabData);
		}
	};

	return UserTabs;
});