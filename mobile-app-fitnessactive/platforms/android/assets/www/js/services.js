angular.module('services', ['ngResource'])


.factory('Data', function($resource){
	//var PROD = http://fitnessactive.altervista.org/web-service-fitnessactive/:resource/:id
	// 	  DEV  = http://localhost/fitnessactive/web-service-fitnessactive/:resource/:id
  	return $resource('http://fitnessactive.altervista.org/web-service-fitnessactive/:resource/:id', 
            { resource: '@resource',
              id: '@id',
            }, {});
});
