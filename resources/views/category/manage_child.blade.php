<ul>
    @foreach ($categoryArray as $cat)
    <li class="{{ !empty($cat['sub_category']) && count($cat['sub_category']) ? 'has_sub' : ''}}">
        <div class="category-detail">
            <span class="display-text">{{ $cat['name'] }}</span>
            <input type="text" class="edit-text d-none form-control form-control-sm" name="cat_name" data-id="{{ $cat['id'] }}" data-parent="{{ $cat['parent_id'] }}" value="{{ $cat['name'] }}">
            <button class="btn btn-sm btn-default add-btn edit-group" data-id="{{ $cat['id'] }}"><i class="fa fa-plus"></i></button>
            <button class="btn btn-sm btn-warning edit-btn edit-group"><i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-danger delete-btn edit-group" data-id="{{ $cat['id'] }}"><i class="fa fa-times-circle"></i></button>
            <button class="btn btn-sm btn-success save-btn save-group d-none"><i class="fa fa-check"></i></button>
            <button class="btn btn-sm btn-defaule cancel-btn save-group d-none"><i class="fa fa-times"></i></button>
        </div>
        @if(!empty($cat['sub_category']) && count($cat['sub_category']))
            @include('category.manage_child',['categoryArray' => $cat['sub_category']])
        @endif
    </li>
    @endforeach
</ul>
