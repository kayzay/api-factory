@extends('layouts.base')
@section('elem_container')
    <script src="/js/machines.js"></script>
    <style>
        .details-control {
            background: url('/img/details_open.png') no-repeat left center;
            padding-left: 30px;
            margin-right: 1rem;
            background-color: #5c636a;
            background-position-x: 3px;
        }
        .details .details-control {
            background: url('/img/details_close.png') no-repeat left center;
            padding-left: 30px;
            margin-right: 1rem;
            background-color: #5c636a;
            background-position-x: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="py-5 text-center">
        <h2>Список станков</h2>
    </div>
    <div class="container">
        <div class=" row">
            <div class="col-11">
                <table id="machines" class="table table-striped"></table>
                <input name="r_show_list" type="hidden" value="{{route("machines.show", ['machine' => "number"])}}">
            </div>
        </div>
    </div>
    <input name="history" type="hidden" value="{{ route("mch-history", ['id' => 'number']) }}">
@endsection
