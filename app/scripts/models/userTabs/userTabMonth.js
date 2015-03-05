app.factory('UserTabMonth', function(){
	function UserTabMonth(gains, items, balance) {
		this.gains = gains;
		this.items = items;
		this.balance = balance;
	}

	UserTabMonth.prototype.getGains = function() {
		return this.gains;
	};

	UserTabMonth.prototype.getItems = function() {
		return this.items;
	};

	UserTabMonth.prototype.getBalance = function() {
		return this.balance;
	};

	UserTabMonth.build = function(data) {
		return new UserTabMonth(
			data.gains,
			data.items,
			data.balance);
	};

	return UserTabMonth;
});