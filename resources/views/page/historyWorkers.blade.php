@extends('layouts.base')
@section('elem_container')
    <script type="text/javascript" src="{{ asset("js/history-worker.js") }}"></script>
@endsection
@section('content')
    <div class="py-5 text-center">
        <h2>История</h2>
    </div>
    <div class="container">
        <div class=" row">
            <div class="col-11">
                <table id="history-workers"  class="table table-striped" style="width:100%" data-id="{{$id}}"></table>
            </div>
        </div>
    </div>
@endsection
