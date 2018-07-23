@extends('templates.template')

@section('content')
    <div class="container">
        <div class="group-items">
            <p class="item-title">
                <span class="item-title-label">Đường dẫn đến cuộc thăm dò ý kiến: </span>
            </p>
            <div class="item-demo">
                <a href="{{route('event.show', ['id'=>$id])}}">{{route('event.show', ['id'=>$id])}}</a>
            </div>
        </div>
    </div>
@endsection

