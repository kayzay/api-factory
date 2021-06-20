@extends('layouts.base')
@section('elem_container')
    <script src="{{ asset("js/workers.js") }}"></script>
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
        <h2>Список Работников</h2>
    </div>
    <div class="container">
        <div class=" row">
            <div class="col-11">
            <table id="workers" class="table table-striped"></table>
                <input name="r_show_list" type="hidden" value="{{route("workers.show", ['worker' => "number"])}}">
                <input name="add_to_list" type="hidden" value="{{ route("queue.store") }}">
                <input name="show_list" type="hidden" value="{{ route("getActiveList") }}">
                <input name="remove_queue" type="hidden" value="{{ route("queue.destroy", ['queue' => "number"]) }}">
                <input name="history" type="hidden" value="{{ route("wr-history", ['id' => 'number']) }}">
            </div>
        </div>
    </div>
    <div class="modal" id="myModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выберете станок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select
                        class="form-select form-select-lg mb-3"
                        aria-label=".form-select-lg example">
                    </select>
                    <p class="mess"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary add-to-list">Сохронить</button>
                </div>
            </div>
        </div>
    </div>
@endsection


