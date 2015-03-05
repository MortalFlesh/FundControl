app.factory('GainTypes', function(GainType){
	function GainTypes(gainTypes) {
		this.gainTypes = gainTypes;
	}

	GainTypes.prototype.getGainTypes = function(){
		return this.gainTypes;
	};

	GainTypes.build = function(data) {
		var gainTypes = [];
		
		angular.forEach(data, function(gainTypeData){
			var Type = GainType.build({name:gainTypeData.name, id:gainTypeData.id});
			gainTypes.push(Type);
		});

		return new GainTypes(gainTypes);
	};

	GainTypes.apiResponseTransformer = function(responseData) {
		if (angular.isArray(responseData)) {
			return responseData
				.map(GainTypes.build)
				.filter(Boolean);
		}
		return GainTypes.build(responseData);
	};

	return GainTypes;
});