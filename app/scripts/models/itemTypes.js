app.factory('ItemTypes', function(){
	function ItemTypes(itemTypes) {
		this.itemTypes = itemTypes;
	}

	ItemTypes.prototype.getItemTypes = function(){
		return this.itemTypes;
	};

	ItemTypes.build = function(data) {
		// todo: return itemTypes.push -> foreach data -> ItemType.build(data1);
		console.log('typesBuild');
		console.log(data);
		return new ItemTypes(data.itemTypes);
	};

	ItemTypes.apiResponseTransformer = function(responseData) {
		if (angular.isArray(responseData)) {
			return responseData
				.map(ItemTypes.build)
				.filter(Boolean);
		}
		return ItemTypes.build(responseData);
	};

	return ItemTypes;
});