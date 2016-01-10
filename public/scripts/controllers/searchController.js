/**
 * Created by kliko on 10/9/15.
 */
app.controller('searchController', function ($scope, searchService) {
    $scope.searchQuery = function (text) {
        searchService.search(text)
            .then(function (serverData) {
                $scope.searchResults = serverData;
                $scope.hasResults = serverData.data.length;
                console.log(serverData);
            }, function (error) {
                console.log(error);
            });
    };
});