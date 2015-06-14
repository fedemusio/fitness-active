angular.module('services', ['ngResource'])


.factory('Data', function($resource){
	//var host = 
  	return $resource('/fitnessactive/web-service-fitnessactive/:resource/:id', 
            { resource: '@resource',
              id: '@id',
            }, {});
});
