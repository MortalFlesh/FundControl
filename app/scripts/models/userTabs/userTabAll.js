app.factory('UserTabAll', function(){
	function UserTabAll(data) {
		this.data = data;
	}

	UserTabAll.prototype.getData = function() {
		return this.data;
	};

	UserTabAll.build = function(data) {
		return new UserTabAll(data);
	};

	return UserTabAll;
});