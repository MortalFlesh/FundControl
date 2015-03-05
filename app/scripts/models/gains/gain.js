app.factory('Gain', function(GainType){
	function Gain(id, name, GainType, amount) {
		this.id = id;
		this.name = name;
		this.gainTypeId = GainType.getId();
		this.GainType = GainType;
		this.amount = amount;
	}

	Gain.prototype.getId = function() {
		return this.id;
	};

	Gain.prototype.getName = function() {
		return this.name;
	};

	Gain.prototype.getGainTypeId = function() {
		return this.gainTypeId;
	};

	Gain.prototype.getGainType = function() {
		return this.GainType;
	};

	Gain.prototype.getAmount = function() {
		return this.amount;
	};

	Gain.build = function(data) {
		return new Gain(
			data.id,
			data.name,
			GainType.build(data.gainType),
			data.amount);
	};

	return Gain;
});