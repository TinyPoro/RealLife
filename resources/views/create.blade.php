@extends('templates.template')

@section('content')
    <div class="container">
        <form action="{{route('event.store')}}" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

            <div class="row">
                <div class="col-3 column-1">
                    <div class="group-items">
                        <p class="item-title">
                            <span class="item-title-label">Bước 1</span>
                            Tên sự kiện
                        </p>
                        <div class="item-demo">
                            <p>※Ăn sinh nhật Tuấn, Ăn mừng Nam bếu giảm cân, ...</p>
                        </div>
                        <p>
                            <input id="title" class="form-input" maxlength="100" name="title" value="" type="text">													</p>
                    </div>

                    <div class="group-div last-group">
                        <p class="item-title">Ghi chú
                            <span style="font-size:0.8em">（tùy chọn）
                        </span></p>
                        <div class="item-demo">
                            <p>※Nhân dịp sinh nhật Tún anh em ra quán làm tí</p>
                        </div>
                        <textarea rows="10" id="comment" class="form-textarea" name="description"></textarea>
                    </div>
                </div>

                <div class="col-3 column-2 clearfix">
                    <div class="group-items">
                        <p class="item-title">
                            <span class="item-title-step-label-span">BƯỚC 2</span>
                            Các lựa chọn</p>
                        <div class="item-demo">
                            <p>※ Ấn tab hoặc enter để thêm lựa chọn</p>
                        </div>

                        <div id="options-group">
                            <input type="text" id="addOption" placeholder="Thêm tùy chọn" value=""/>
                            <input type="hidden" name="options"/>
                        </div>
                    </div>
                </div>

                <div class="col-3 column-3">
                    <div class="group-items">
                        <p class="item-title">
                            <span class="item-title-step-label-span">BƯỚC 3</span>
                            Tạo cuộc thăm dò</p>

                        <div class="group-div last-group">
                            <p class="item-title">Thời gian bắt đầu</p>
                            <div class="item-demo">
                                <p>※Chọn thời gian bắt đầu tạo cuộc thăm dò</p>
                            </div>
                            <input type="datetime-local" name="started_at"/>
                        </div>

                        <div class="group-div last-group">
                            <p class="item-title">Thời gian kết thúc</p>
                            <div class="item-demo">
                                <p>※Thời gian kết thúc cuộc thăm dò</p>
                            </div>
                            <input type="datetime-local" name="ended_at"/>
                        </div>
                    </div>

                    <div class="group-items">
                        <input type="submit" name="submit" class="submit action-button" value="Tạo cuộc thăm dò" />
                    </div>
                </div>
            </div>
        </form>
    </div>
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

            if(!option) return;

            let hidden_element = $('input[name="options"]');
            let cur_options = hidden_element.val();
            hidden_element.val(cur_options+';'+option);
            option_element.val('');

            let html = '<input type="text" disabled value="'+option+'" />';
            option_element.before(html);
        }

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());

            return local.toJSON().slice(0,16);
        });

        $(document).ready( function() {
            $('input[name="started_at"]').val(new Date().toDateInputValue());
            $('input[name="ended_at"]').val(new Date().toDateInputValue());
        })
    </script>
@endsection
