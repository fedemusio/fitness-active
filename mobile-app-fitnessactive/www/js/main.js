angular.module('fitness-app', ['services', 'ngRoute', 'controllers'])

.config(['$routeProvider', function($routeProvider) {
       
    $routeProvider.when('/all-instructors', 
        {templateUrl: 'partials/all-instructors.html', 
         controller: "AllInstructors"});
     
    $routeProvider.when('/all-categories', 
        {templateUrl: 'partials/all-categories.html', 
         controller: "AllCategories"});
    
    $routeProvider.when('/all-courses/:level', 
        {templateUrl: 'partials/all-courses.html', 
         controller: "AllCourses"});
    
    $routeProvider.when('/register', 
        {templateUrl: 'partials/register.html', 
         controller: "Register"});
    
    $routeProvider.when('/course/:id', 
        {templateUrl: 'partials/course.html', 
         controller: "Course"});
    
    $routeProvider.when('/category/:id', 
        {templateUrl: 'partials/category.html', 
         controller: "Category"});

    $routeProvider.when('/instructor/:id', 
        {templateUrl: 'partials/instructor.html', 
         controller: "Instructor"});

    $routeProvider.when('/location', 
        {templateUrl: 'partials/location.html'});

    
    // default fallback page:
    $routeProvider.otherwise({redirectTo: '/main'});
    
  }]);
