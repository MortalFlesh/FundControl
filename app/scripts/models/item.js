app.factory('Item', function(ItemType){
	function Item(id, name, ItemType, amount) {
		this.id = id;
		this.name = name;
		this.itemTypeId = ItemType.getId();
		this.ItemType = ItemType;
		this.amount = amount;
	}

	Item.prototype.getId = function() {
		return this.id;
	};

	Item.prototype.getName = function() {
		return this.name;
	};

	Item.prototype.getItemTypeId = function() {
		return this.itemTypeId;
	};

	Item.prototype.getItemType = function() {
		return this.ItemType;
	};

	Item.prototype.getAmount = function() {
		return this.amount;
	};

	Item.build = function(data) {
		return new Item(
			data.id,
			data.name,
			ItemType.build(data.itemType),
			data.amount);
	};

	return Item;
});