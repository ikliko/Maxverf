@foreach($catChild -> products as $cProduct)
@include('sections.product-shop', ['product' => $cProduct])
@endforeach