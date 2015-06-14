angular.module('controllers', [])

.controller('AllInstructors', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    
    var compare = function (a,b) {
        if (a.FirstName < b.FirstName)
            return -1;
        if (a.FirstName > b.FirstName)
            return 1;
        return 0;
    }
    
    var temp =  Data.query(
    		{
    			resource: 'instructors',
    			id: null
    		});
    temp.sort(compare);
    $scope.instructors = temp;
}])

.controller('AllCategories', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    var id = $routeParams.id;
    $scope.categories = Data.query(
    		{
    			resource: 'categories',
    			id: null
    		});
}])

.controller('Category', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    var id = $routeParams.id;
    
    $scope.courses = Data.query(
    		{
    			resource: 'courses',
    			id: id,
                join: 'categories'
    		});
            
    $scope.category = Data.get(
    		{
    			resource: 'categories',
    			id: id
    		});

}])

.controller('AllCourses', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    var level = $routeParams.level;
    $scope.reverse = false;
    
    if (level == 'by-level') {
        $scope.islevel = true;
        $scope.subtitle = "By Level";
	$scope.predicate = "Level";
    }
    else {
        $scope.islevel = false;
    }
        
    if (level == 'by-alpha') {
        $scope.isalpha = true;
        $scope.subtitle = "Alphabetic";
	$scope.predicate = "CourseName";
    } 
    else {
        $scope.isalpha = false;
    }


        
    var result = Data.query(
    		{
    			resource: 'courses',
    			id: null
    		});
    
    result.sort(function compare(a,b) {
                if (a.CourseName < b.CourseName)
                    return -1;
                if (a.CourseName > b.CourseName)
                    return 1;
                return 0;
            });
    
    $scope.courses = result;
}])


.controller('Course', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    var id = $routeParams.id;
    $scope.course = Data.get(
    		{
    			resource: 'courses',
    			id: id
    		}, function() {
            
            $scope.instr1 = Data.get(
                {
                    resource: 'instructors',
                    id: $scope.course.Instructor1
                });

            $scope.instr2 = Data.get(
                {
                    resource: 'instructors',
                    id:  $scope.course.Instructor2
                });

            $scope.category = Data.get(
                {
                    resource: 'categories',
                    id:  $scope.course.Category
    	});
        
    });
    
}])

.controller('Register', ['$scope','Data', '$routeParams', '$location', function($scope, Data, $routeParams, $location ) {

    $scope.submit = function() {
        var name = $scope.firstname;
        var surname = $scope.lastname;
        var email = $scope.email;
        
        Data.save({
            resource: 'member',
            id: null,
            firstname: name,
            lastname: surname,
            email: email
        }, function(data) {
            console.log(data);
        });
        
        $location.path("#/");
    };
    
}])

.controller('Instructor', ['$scope','Data', '$routeParams', function($scope, Data, $routeParams) {
    var id = $routeParams.id;
    $scope.instructor = Data.get(
    		{
    			resource: 'instructors',
    			id: id
    		});

    $scope.courses = Data.query(
    		{
    			resource: 'courses',
    			id: id,
			join: 'instructors'
    		});
}]);
