// https://gist.github.com/atuttle/8804601
app.factory('API', function($http, $q) {
	var basePath = homeUrl;

	function makeRequest(verb, uri, data) {
		var defer = $q.defer();
		verb = verb.toLowerCase();

		//start with the uri
		var httpArgs = [basePath + uri];
		if (verb.match(/post|put/)) {
			httpArgs.push(data);
		}

		$http[verb].apply(null, httpArgs)
			.success(function(data, status) {
				defer.resolve(data);
				// update angular's scopes
				// $rootScope.$$phase || $rootScope.$apply();
			})
			.error(function(data, status) {
				defer.reject('HTTP Error: ' + status);
			});

		return defer.promise;
	}

	return {
		get: function(uri) {
			return makeRequest('get', uri);
		}
		, post: function(uri, data) {
			return makeRequest('post', uri, data);
		}
		, put: function(uri, data) {
			return makeRequest('put', uri, data);
		}
		, delete: function(uri) {
			return makeRequest('delete', uri);
		}
	};

});