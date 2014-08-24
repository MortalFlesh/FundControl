app.factory('GainType', function(){
	function GainType(id, name) {
		this.id = id;
		this.name = name;
	}

	GainType.prototype.getId = function() {
		return parseInt(this.id);
	};

	GainType.prototype.getName = function() {
		return this.name;
	};

	GainType.build = function(data) {
		return new GainType(data.id, data.name);
	};

	GainType.apiResponseTransformer = function(responseData) {
		if (angular.isArray(responseData)) {
			return responseData
				.map(GainType.build)
				.filter(Boolean);
		}
		return GainType.build(responseData);
	};

	return GainType;
});