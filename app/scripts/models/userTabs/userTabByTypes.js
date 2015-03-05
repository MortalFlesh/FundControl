app.factory('UserTabByTypes', function(){
	function UserTabByTypes(data) {
		this.data = data;
	}

	UserTabByTypes.prototype.getData = function() {
		return this.data;
	};

	UserTabByTypes.build = function(data) {
		return new UserTabByTypes(data);
	};

	return UserTabByTypes;
});