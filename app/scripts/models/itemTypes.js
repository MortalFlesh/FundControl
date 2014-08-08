app.factory('ItemTypes', function(ItemType){
	function ItemTypes(itemTypes) {
		this.itemTypes = itemTypes;
	}

	ItemTypes.prototype.getItemTypes = function(){
		return this.itemTypes;
	};

	ItemTypes.build = function(data) {
		var itemTypes = [];
		
		angular.forEach(data, function(name, id){
			var Type = ItemType.build({name:name, id:id});
			itemTypes.push(Type);
		});

		return new ItemTypes(itemTypes);
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