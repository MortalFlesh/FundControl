app.factory('Items', function(Item){
	function Items(items) {
		this.items = items;
	}

	Items.prototype.getItems = function(){
		return this.items;
	};

	Items.build = function(data) {
		var items = [];
		
		angular.forEach(data, function(data, key){
			var item = Item.build(data);
			items.push(item);
		});

		return new Items(items);
	};

	Items.apiResponseTransformer = function(responseData) {
		return Items.build(responseData);
	};

	return Items;
});