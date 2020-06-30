@extends('layouts.app')

{{-- Style Section --}}
@section('styles')
<style type="text/css">
    li{
        padding: 10px;
    }
    .form-control{
        width: auto;
        max-width: 200px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="container">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="submit_notification">
                @if (Session::has('message'))
                <div class="text-{{ Session::get('status') }}">
                    {{ Session::get('message') }}
                </div>
                @endif
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12"> 
                Categories <button type="button" class="btn btn-sm add-main-category btn-defailt" data-href="{{ URL::to('category/create') }}" title="Add"><i class="fa fa-plus"></i></button>
                <div class="clearfix"></div>
                <div class="nestable-list">
                @if(!empty($categoryArray) && count($categoryArray))
                    @include('category.manage_child',['categoryArray' => $categoryArray])
                @endif
                </div>
            </div>
        </div>
        <li class="blank-li d-none">
            <div class="category-detail">
                <span class="display-text d-none"></span>
                <input type="text" class="edit-text form-control form-control-sm" name="cat_name" data-id="" data-parent="" value="">
                <button class="btn btn-sm btn-default add-btn edit-group d-none" data-id=""><i class="fa fa-plus"></i></button>
                <button class="btn btn-sm btn-warning edit-btn edit-group d-none"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-btn edit-group d-none"><i class="fa fa-times-circle"></i></button>
                <button type="button" class="btn btn-sm btn-success save-btn save-group "><i class="fa fa-check"></i></button>
                <button class="btn btn-sm btn-defaule cancel-btn save-group"><i class="fa fa-times"></i></button>
            </div>
        </li>
    </section>
</div>
@endsection

{{-- Scripts Section --}}
@section('scripts')

<script type="text/javascript">

    var saveUrl = "{{ url('category/save') }}";
    var deleteUrl = "{{ url('category/delete') }}/";

</script>
@endsection
