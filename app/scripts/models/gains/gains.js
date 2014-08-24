app.factory('Gains', function(Gain){
	function Gains(gains) {
		this.gains = gains;
	}

	Gains.prototype.getGains = function(){
		return this.gains;
	};

	Gains.build = function(data) {
		var gains = [];
		
		angular.forEach(data, function(data, key){
			var gain = Gain.build(data);
			gains.push(gain);
		});

		return new Gains(gains);
	};

	Gains.apiResponseTransformer = function(responseData) {
		return Gains.build(responseData);
	};

	return Gains;
});