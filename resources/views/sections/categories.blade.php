<style>
    .cat-no-childs {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
</style>
<ul class="cd-accordion-menu">
    @foreach($categories as $category)
    @if(count($category -> childs))
    <li class="has-children">
        <input type="checkbox" name ="group-{{{ $category -> id }}}" id="group-{{{ $category -> id }}}" @if($category -> id === $current_category) checked @endif>
        <label for="group-{{{ $category -> id }}}">{{{ $category -> title }}}</label>

        <ul>
            <li><a href="{{{ url('shop/category/' . $category -> id) }}}">{{{ $category -> title }}}</a></li>
            @foreach($category -> childs as $child)
            @if(count($child -> childs))
            <li class="has-children">
                <input type="checkbox" name ="group-{{{ $child -> id }}}" id="group-{{{ $child -> id }}}">
                <label for="group-{{{ $child -> id }}}">{{{ $child -> title }}}</label>

                <ul>
                    <li><a href="{{{ url('shop/category/' . $child -> id) }}}">{{{ $child -> title }}}</a></li>
                    @foreach($child -> childs as $gChild)
                    @if(count($gChild -> childs))
                    <li class="has-children">
                        <input type="checkbox" name ="group-{{{ $gChild -> id }}}" id="group-{{{ $gChild -> id }}}">
                        <label for="group-{{{ $gChild -> id }}}">{{{ $gChild -> title }}}</label>

                        <ul>
                            <li><a href="{{{ url('shop/category/' . $gChild -> id) }}}">{{{ $gChild -> title }}}</a></li>
                            @foreach($gChild -> childs as $ggChilds)
                            <ul>
                                <li><a href="{{{ url('shop/category/' . $ggChild -> id) }}}">{{{ $ggChild -> title }}}</a></li>
                            </ul>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li><a href="{{{ url('shop/category/' . $gChild -> id) }}}">{{{ $gChild -> title }}}</a></li>
                    @endif
                    @endforeach
                </ul>
            </li>
            @else
            <li><a href="{{{ url('shop/category/' . $child -> id) }}}">{{{ $child -> title }}}</a></li>
            @endif
            @endforeach
        </ul>
    </li>
    @else
    <li class="has-children">
        <a href="{{{ url('shop/category/' . $category -> id) }}}" class="cat-no-childs"><label>{{{ $category -> title }}}</label></a>
    </li>
    @endif
    @endforeach
</ul> <!-- cd-accordion-menu -->
<!--/category-products-->