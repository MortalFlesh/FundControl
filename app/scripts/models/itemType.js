app.factory('ItemType', function(){
	function ItemType(id, name) {
		this.id = id;
		this.name = name;
	}

	ItemType.prototype.getId = function() {
		return this.id;
	};

	ItemType.prototype.getName = function() {
		return this.name;
	};

	ItemType.build = function(data) {
		return new ItemType(data.id, data.name);
	};

	ItemType.apiResponseTransformer = function(responseData) {
		if (angular.isArray(responseData)) {
			return responseData
				.map(ItemType.build)
				.filter(Boolean);
		}
		return ItemType.build(responseData);
	};

	return ItemType;
});