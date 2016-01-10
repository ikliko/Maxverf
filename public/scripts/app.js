/**
 * Created by kliko on 18.06.15.
 */
var app = angular.module('maxverf', ['ngResource'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}).constant('baseUrl', 'http://localhost:8000/api');