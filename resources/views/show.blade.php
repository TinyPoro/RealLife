@extends('templates.template')

@section('after-css')
  <link href="{{url('css/option.css')}}" rel="stylesheet">
@endsection

@section('content')
  <div class="PDS_Poll" id="PDI_container9369622">
    <div class="pds-box">
      <div class="pds-box-outer">
        <div class="pds-box-inner">
          <div class="pds-box-top">

            <div id="voting">
              <div class="pds-question">
                <div class="pds-question-outer">
                  <div class="pds-question-inner">
                    <div class="pds-question-top">
                      {{$event->title}}?
                    </div>
                  </div>
                </div>
              </div>

              <div class="pds-answer">
                <span id="pds-answer9369622">
                  @foreach($event->options as $option)
                    <span class="pds-answer-group">
                      <span class="pds-answer-input">
                        <input class="pds-radiobutton" type="radio" id="{{$option->id}}" value="{{$option->content}}" name="option"></span>
                      <label for="PDI_answer42726265" class="pds-input-label">
                        <span class="pds-answer-span">{{$option->content}}</span>
                      </label>
                      <span class="pds-clear"></span>
                      <br>
                    </span>
                  @endforeach
                </span>
              </div>

              <div class="pds-vote">
                <div class="pds-totalvotes-outer">
                  <a id="pd-vote-button9369622" class="pds-vote-button"><span>Vote</span></a>
                  <a id="pd-show-result" class="pds-vote-button"><span>Xem kết quả</span></a>

                  <span class="pds-clear" style="display: block;clear: both;height:1px;line-height:1px;">&nbsp;</span>
                </div>
              </div>
            </div>

            <div id="result" style="display: none;">
              <div class="pds-question">
                <div class="pds-question-outer">
                  <div class="pds-question-inner">
                    <div class="pds-question-top">
                      Câu trả lời của bạn đã được ghi lại.
                    </div>
                  </div>
                </div>
              </div>

              <?php
                $total_vote = 0;

                foreach($event->options as $option){
                    $total_vote += $option->vote;
                }
                ?>

              <div class="pds-answer">
                @foreach($event->options as $option)
                  <div class="pds-feedback-group option_{{$option->id}}">
                    <label class="pds-feedback-label">
                      <span class="pds-answer-text"> {{$option->content}} </span>
                      <span class="pds-feedback-result">
                        @if($total_vote == 0)
                              <span class="pds-feedback-per">0 %</span>
                        @else
                              <span class="pds-feedback-per">&nbsp;{{$option->vote*100/$total_vote}}%</span>
                          @endif
                        <span class="pds-feedback-votes">&nbsp; ({{$option->vote}} votes)</span>
                      </span>
                    </label>

                    <span class="pds-clear" style="display: block;clear: both;height:1px;line-height:1px;">&nbsp;</span>

                    <div class="pds-answer-feedback" id="PDI_feedback0">
                        @if($total_vote == 0)
                            <div class="pds-answer-feedback-bar" style="0"></div>
                        @else
                            <div class="pds-answer-feedback-bar" style="width:{{$option->vote*100/$total_vote}}%"></div>
                        @endif
                    </div>

                    <span class="pds-clear" style="display: block;clear: both;height:1px;line-height:1px;">&nbsp;</span>
                  </div>
                @endforeach

                <span class="pds-clear" style="display: block;clear: both;height:1px;line-height:1px;">&nbsp;</span>

                <div class="pds-total-votes">Total Votes:
                  <span>{{$total_vote}}</span>
                </div>
              </div>

              <div class="pds-vote">
                <div class="pds-totalvotes-outer">
                <span class="pds-links-back">
                  <a id="btn_return" class="pds-return-poll" href="">Return To Poll</a>
                </span>

                  <span class="pds-clear" style="display: block;clear: both;height:1px;line-height:1px;">&nbsp;</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" id="event_id" value="{{$event->id}}">
@endsection

@section('after-scripts')
  <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $("#pd-vote-button9369622").click(function(){
        var has_check = false;

        $('#pds-answer9369622 .pds-radiobutton').each(function(index, ele){
            if(ele.checked){
                has_check = true;

                //cập nhật vote cho option
                let option_id = ele.id;

                $.ajax({
                    method: 'POST',
                    url: "/vote",
                    data: {option_id:option_id},
                    success: function(result){
                        console.log(result);
                    }
                });

                updateInfo();
            }
        });

        if(!has_check){
            alert('Bạn cần phải chọn 1 mục nào đó!');
            return;
        }

        $('#voting').hide();
        $('#result').show();
    });

    var updateInfo = function(){
        let id = $('#event_id').val();

        $.ajax({
            method: 'GET',
            url: "/info/"+id,
            success: function(result){
                $('.pds-total-votes span').text(result['total']);
                result['options'].forEach(function(ele){
                    let box = $('.option_'+ele['id']);
                    box.find('.pds-feedback-per').html("&nbsp;"+Math.round(ele['vote']*100/result['total'])+"%");
                    box.find('.pds-feedback-votes').html("&nbsp; ("+ele['vote']+" votes)");
                    box.find('.pds-answer-feedback-bar').css("width", (ele['vote']*100/result['total'])+"%");
                });
            }
        });
    };

    setInterval(updateInfo, 5000);

    $("#pd-show-result").click(function(){
        $('#voting').hide();
        $('#result').show();
    });

    $("#btn_return").click(function(){
        $('#voting').show();
        $('#result').hide();
    });
  </script>
@endsection