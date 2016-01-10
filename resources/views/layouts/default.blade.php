<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{{ isset($description) ? $description : '' }}}">
    <meta name="author" content="">
    <title>Maxverf{{{ isset($title) ? ' | ' . $title : '' }}}</title>
    <link href="{{{ asset('css/bootstrap.min.css') }}}" rel="stylesheet">
    <link href="{{{ asset('css/main.css') }}}" rel="stylesheet">
    <link href="{{{ asset('css/responsive.css') }}}" rel="stylesheet">
</head><!--/head-->
<body ng-app="maxverf" ng-cloack>
@yield('body')
<script src="{{{ asset('js/jquery.js') }}}"></script>
<script src="{{{ asset('js/bootstrap.min.js') }}}"></script>
<script src="{{{ asset('js/modernizr.custom.js') }}}"></script>
<script src="{{{ asset('js/classie.js') }}}"></script>
<script src="{{{ asset('js/main.js') }}}"></script>
<script src="{{{ asset('scripts/libs/angular.min.js') }}}"></script>
<script src="{{{ asset('scripts/libs/angular-resource.min.js') }}}"></script>
<script src="{{{ asset('scripts/app.js') }}}"></script>
<script src="{{{ asset('scripts/controllers/sizeController.js') }}}"></script>
<script src="{{{ asset('scripts/controllers/searchController.js') }}}"></script>
<script src="{{{ asset('scripts/services/sizeService.js') }}}"></script>
<script src="{{{ asset('scripts/services/searchService.js') }}}"></script>
</body>
</html>