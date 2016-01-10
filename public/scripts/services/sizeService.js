/**
 * Created by kliko on 10/9/15.
 */
app.factory('sizeService', function($http, $q, baseUrl){
    var service = {};
    var serviceUrl = baseUrl + '/size';

    function makeRequest (method, url, headers, data) {
        var defer = $q.defer();
        $http({
            method: method,
            url: url,
            headers: headers,
            data: data
        }).success(function (data, status, headers, config) {
            defer.resolve(data);
        }).error(function (data, status, headers, config) {
            defer.reject(data);
        });

        return defer.promise;
    }

    service.getSizeColor = function(id) {
        return makeRequest('GET', serviceUrl + '/' + id + '/colors');
    };

    return service;
});