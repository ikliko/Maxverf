@if(isset($category))
@foreach($category -> childs as $child)
@include('sections.category-childs-products', array('catChild' => $child))
@foreach($child -> childs as $gChild)
@include('sections.category-childs-products', array('catChild' => $child))
@foreach($gChild -> childs as $ggChild)
@include('sections.category-childs-products', array('catChild' => $child))
@endforeach
@endforeach
@endforeach
@endif