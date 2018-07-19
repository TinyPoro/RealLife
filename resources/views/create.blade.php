@extends('templates.nbs-template')

@section('after-css')
    <link href="{{url('css/create.css')}}" rel="stylesheet">

    <style>
        fieldset label{
            font-weight: bold;
            font-size: 15px;
            float: left;
            margin-bottom: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <span id="back-box">
        <a href="{{route('event.index')}}" class="button-primary">Quay lại</a>
    </span>
    <!-- multistep form -->
    <form id="msform" method="post" action="{{route('event.store')}}">
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">Nhập thông tin sự kiện</li>
            <li>Thêm các lựa chọn</li>
            <li>Xuất bản sự kiện</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>
            <h2 class="fs-title">Tạo sự kiện mới</h2>
            <h3 class="fs-subtitle">Bước 1</h3>
            <input type="text" name="title" placeholder="Tiêu đề" />
            <input type="textarea" name="description" placeholder="Mô tả sự kiện" />
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Thêm các tùy chọn</h2>
            <h3 class="fs-subtitle" id="before-options">Bước 2</h3>
            <input type="text" id="addOption" placeholder="Thêm tùy chọn" />
            <input type="hidden" name="options"/>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Xuất bản sự kiện</h2>
            <h3 class="fs-subtitle">Bước 3</h3>
            <label>Thời gian kết thúc</label>
            <input type="datetime-local" name="ended_at"/>

            <label>Thời gian bắt đầu</label>
            <input type="datetime-local" name="started_at"/>

            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>
    </form>
@endsection

@section('after-scripts')
    <script src="{{url('js/create.js')}}"></script>
    <script>
        $('#addOption').keydown(function(e) {
            let code = e.keyCode || e.which;

            if(code === 13) {
                addOption();
            }

            if (code === 9) {
                e.preventDefault();
                addOption();
            }
        });

        let addOption = function(){
            let option_element = $('#addOption');
            let option = option_element.val();

            let hidden_element = $('input[name="options"]');
            let cur_options = hidden_element.val();
            hidden_element.val(cur_options+';'+option);
            option_element.val('');

            let html = '<input type="text" disabled placeholder="Thêm tùy chọn" value="'+option+'" />';
            $('#before-options').after(html);
        }

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());

            return local.toJSON().slice(0,16);
        });

        $(document).ready( function() {
            $('input[name="started_at"]').val(new Date().toDateInputValue());
        })
    </script>
@endsection
