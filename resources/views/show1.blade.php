@extends('templates.template')

@section('after-css')
  <link href="{{url('css/show1.css')}}" rel="stylesheet">

  <style type="text/css">
      .d-loadingScreen {
          position: absolute;
          top: 0;
          left: 0;
          z-index: 99999;
          display: table;
          width: 100%;
          height: 100%;
      }
      .d-loadingCenterer {
          display: table-cell;
          vertical-align: middle;
      }
      .d-loadingLogo {
          display: block;
          margin-left: auto;
          margin-right: auto;
          width: 178px;
      }
      .d-loadingSpinner {
          border-radius: 100%;
          margin: 20px auto;
          border: 10px solid rgba(226, 230, 233, 0.7);
          border-bottom-color: transparent;
          height: 40px;
          width: 40px;
          -webkit-animation: d-spinner 1s 0s linear infinite;
          animation: d-spinner 1s 0s linear infinite;
      }
      @-webkit-keyframes d-spinner {
          0% {
              -webkit-transform: rotate(0deg);
              transform: rotate(0deg);
          }
          100% {
              -webkit-transform: rotate(360deg);
              transform: rotate(360deg);
          }
      }
      @keyframes d-spinner {
          0% {
              -webkit-transform: rotate(0deg);
              transform: rotate(0deg);
          }
          100% {
              -webkit-transform: rotate(360deg);
              transform: rotate(360deg);
          }
      }
  </style>
@endsection

@section('content')
    <div id="d-participationPage">
        <div class="d-pageContent">
            <div class="d-mainContentContainer">
                <div class="d-mainContentInnerContainer">
                    <div class="d-beforeTabs">

                        <section id="d-metadataView" class=""><div class="d-pollMetadata">
                                <div class="d-pollDescription d-pollMetadataRow ">
                                    <div>
                                        <div class="d-contentContainer">
                                            <div class="d-content">{{$event->title}}
                                                <span>
                                                    ({{$event->ended_at}})
                                                </span>
                                            </div>
                                            <input type="hidden" value="{{$event->id}}" id="event_id">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div id="d-tabsContent">
                        <div id="d-participationPollTab" role="tabpanel">

                            <section id="d-pollView" class="">
                                <article class="d-poll d-newParticipationMode">
                                    <div class="d-expandableScrollContainer" style="width: auto;">
                                        <div class="d-expandableScrollContentWrapper">
                                            <div class="d-expandableScrollContent">
                                                <aside>
                                                    <header class="d-headerGroup">
                                                        <div class="d-optionsHeader">
                                                            <div class="d-calendarAdHeader">

                                                            </div>
                                                            <div class="d-participantCountHeader">
                                                                <span><b>{{count($event->users)}}</b> người tham gia</span>
                                                            </div>
                                                        </div>
                                                        <div class="d-newParticipant">
                                                            <div class="d-participantInfo">
                                                                <div class="d-formField d-forceSolidBackground d-withText">
                                                                    <div class="d-fieldContainer">

                                                                        <div class="d-inputContainer">
                                                                            <input type="text" id="" placeholder="Enter your name" required="required" maxlength="64">
                                                                        </div>
                                                                    </div>

                                                                </div></div>
                                                            <div class="d-participantExtrasEditButton">

                                                            </div>
                                                        </div>
                                                    </header>
                                                    <ul class="d-participants">
                                                        @foreach($event->users as $user)
                                                            @include('.temp.user_participant', ['user' => $user])
                                                        @endforeach
                                                    </ul>
                                                </aside>

                                                <ul class="d-options">
                                                    @foreach($event->options as $option)
                                                        @include('.temp.option_info', ['option' => $option, 'users' > $users, 'checklist' => $check_list])
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </section></div>
                        <section id="d-pollActionBarView" class="d-actionBarView"><div class="d-stickyContainer" style="left: 0px; right: 0px;">
                                <div class="d-stickyElement"><div class="d-grow"></div><div class="d-counters">
                                    </div><div class="d-actionButtons">
                                        <button type="button" class="d-button d-participateButton d-large d-secondaryButton">
                                            <div class="d-buttonContainer">
                                                <div class="d-buttonContent">

                                                    <div class="d-textContainer">
                                                        <div id="submit" class="d-text">Gửi câu trả lời</div>
                                                    </div>

                                                </div>
                                                <div class="d-buttonState">
                                                </div>
                                            </div>
                                        </button>
                                    </div></div>
                            </div>
                        </section>
                    </div>
                    <section id="d-additionalInformationView" class="d-hideView"></section>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('after-scripts')
  <script>
      $(document).ready(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
      });


    $("#submit").click(function(){
        var has_check = false;
        var optionIds = [];

        $('input[type="checkbox"]').each(function(index, ele){
            if(ele.checked){
                has_check = true;

                optionIds.push(ele.value);
            }
        });

        var name = $('.d-inputContainer input').val();
        var event_id = $('#event_id').val();

        if(!has_check){
            alert('Bạn cần phải chọn 1 mục nào đó!');
            return;
        }

        $.ajax({
            method: 'POST',
            url: "/vote",
            data: {name: name, optionIds:optionIds, event_id:event_id},
            success: function(result){
                if(result === "Over") alert("Đã hết thời gian sự kiện!");
            }
        });

        updateInfo();

        $('input[type="checkbox"]').each(function(index, ele){
            ele.checked = false;
        });

        $('.d-inputContainer input').val('');
    });

    var user_list_html = '';

    var updateInfo = function(){
        let id = $('#event_id').val();

        $.ajax({
            method: 'GET',
            url: "/info/"+id,
            success: async function(result){
                //sửa tổng danh sách người tham gia
                $('.d-participantCountHeader b').text(result['users'].length);

                //chỉnh sửa danh sách người tham gia
                user_list_html = '';
                result['users'].forEach(async function(user){
                    user_list_html += "<li class=\"d-participant\" data-participant-id=\"199552085\">\n" +
                        "    <div class=\"d-participantExtrasAvatar\">\n" +
                        "        <div class=\"d-participantAvatar\">\n" +
                        "\n" +
                        "        </div>\n" +
                        "\n" +
                        "    </div>\n" +
                        "    <div class=\"d-participantInfo\">\n" +
                        "        <div class=\"d-text\">\n" +
                        "            "+user.name+"\n" +
                        "        </div>\n" +
                        "        <div class=\"d-detailText\">\n" +
                        "\n" +
                        "        </div>\n" +
                        "    </div>\n" +
                        "    <div class=\"d-participantExtrasEditButton\">\n" +
                        "        <button type=\"button\" id=\"false\" class=\"d-button d-editParticipantButton d-medium d-silentButton\">\n" +
                        "            <div class=\"d-buttonContainer\">\n" +
                        "                <div class=\"d-buttonState\">\n" +
                        "                </div>\n" +
                        "            </div>\n" +
                        "        </button>\n" +
                        "\n" +
                        "    </div>\n" +
                        "</li>";
                });

                await $('ul.d-participants').html(user_list_html);

                //Cập nhật lại thông tin của các option
                option_info_html = '';
                result['options'].forEach(async function(option){
                    //tính toán %
                    var percent_html ;

                    if(result['users'].length != 0){
                        var percent = option.users.length * 100 / result['users'].length;
                        percent_html = percent.toFixed(2) + '%'
                    }else{
                        percent_html = '0%';
                    }

                    //sinh check list html

                    var check_list_html = '';

                    for(var i in result['check_list'][option.id]){
                        var check = result['check_list'][option.id][i];

                        if(check === 1){
                            check_list_html += "<li class=\" d-yesPreference d-preference\" data-participant-id=\"199552085\">\n" +
                                "                    <i class=\"fa fa-check\" style=\"color:#87C627;\" aria-hidden=\"true\"></i>\n" +
                                "                </li>";
                        }else{
                            check_list_html += "<li class=\" d-noPreference d-preference\" data-participant-id=\"224514269\">\n" +
                                "\n" +
                                "                </li>";
                        }
                    };

                    option_info_html += "<li class=\"d-option\" data-cid=\"c140\" data-optionindex=\"0\">\n" +
                        "    <label class=\"d-headerGroup\" for=\"d-participantPreference-c153-0\">\n" +
                        "        <div class=\"d-optionDate\">\n" +
                        "            <div class=\"d-dateGroup\">\n" +
                        "                "+option.content+"\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "        <div class=\"d-optionDetails\">\n" +
                        "\n" +
                        "            <div class=\"d-participantCount d-bestOption\">\n" +
                        "                <button aria-label=\"1 vote. See participants preferences\" aria-haspopup=\"true\" type=\"button\" class=\"d-button d-countButton d-medium d-silentButton\">\n" +
                        "                    <div class=\"d-buttonContainer\">\n" +
                        "                        <div class=\"d-buttonContent\">\n" +
                        "                            <div class=\"d-textContainer\">\n" +
                        "                                <div class=\"d-text\"> (\n" +
                        "                                    "+option.users.length+"\n" +
                        percent_html+
                        "                                )</div>\n" +
                        "                            </div>\n" +
                        "\n" +
                        "                        </div>\n" +
                        "                        <div class=\"d-buttonState\">\n" +
                        "                        </div>\n" +
                        "                    </div>\n" +
                        "                </button>\n" +
                        "\n" +
                        "                <button aria-label=\"1 vote. See participants preferences\" aria-haspopup=\"true\" type=\"button\" class=\"d-button d-verboseCountButton d-medium d-silentButton\">\n" +
                        "                    <div class=\"d-buttonContainer\">\n" +
                        "                        <div class=\"d-buttonContent\">\n" +
                        "\n" +
                        "                            <div class=\"d-textContainer\">\n" +
                        "                                <div class=\"d-text\">1 vote</div>\n" +
                        "                            </div>\n" +
                        "\n" +
                        "                        </div>\n" +
                        "                        <div class=\"d-buttonState\">\n" +
                        "                        </div>\n" +
                        "                    </div>\n" +
                        "                </button>\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "\n" +
                        "        <!-- closing state -->\n" +
                        "        <div id=\"\" class=\"d-checkbox d-participantPreference d-noPreference\" data-optionindex=\"0\" data-participant-id=\"c153\">\n" +
                        "            <div class=\"d-checkboxWrapper\">\n" +
                        "                <input aria-label=\" \" type=\"checkbox\" id=\"d-participantPreference-c153-"+option.id+"\" value=\""+option.id+"\" name=\"d-participantPreference-c153-"+option.id+"\">\n" +
                        "                <label for=\"d-participantPreference-c153-"+option.id+"\">\n" +
                        "                    <div class=\"d-checkmarkWrapper\">\n" +
                        "                        <svg class=\"d-checkmark\" viewBox=\"0 0 24 24\" fill=\"currentColor\">\n" +
                        "                            <defs>\n" +
                        "                                <clipPath id=\"badgeClip\">\n" +
                        "                                    <path d=\"M13.2463013,-0.999999989 L-1,-0.999999989 L-1,25.003591 L25,25.003591 L25,7.21957071 C20.5747645,7.84262556 16.0533842,5.37951456 12.7409797,-0.19061816 C12.9064595,-0.468116667 13.0749566,-0.737911095 13.2463082,-1 Z\"></path>\n" +
                        "                                </clipPath>\n" +
                        "                            </defs>\n" +
                        "\n" +
                        "\n" +
                        "                            <!-- order is important - ifNeedBe should be rendered below the default checkmark -->\n" +
                        "                            <g class=\"d-ifNeedBeCheckmark\">\n" +
                        "                                <rect class=\"d-background\" stroke-alignment=\"inner\" fill=\"#ffffff\" x=\"0\" y=\"0\" width=\"24\" height=\"24\" rx=\"4\" ry=\"4\"></rect>\n" +
                        "                                <g transform=\"translate(2 2)\">\n" +
                        "                                    <path class=\"d-check\" d=\"M5.92595894,8.73939407 L8.54659942,11.6292341 L14.127404,6.18830469 C14.6217147,5.70638324 15.4131072,5.71642669 15.8950286,6.21073736 C16.3769501,6.70504803 16.3669066,7.49644052 15.872596,7.97836197 L8.43587461,15.2286921 L4.07404106,10.4187988 C3.61028626,9.90740578 3.64890465,9.11689229 4.16029765,8.65313748 C4.67169065,8.18938268 5.46220413,8.22800107 5.92595894,8.73939407 Z M4.46087548,1.75519633 C4.87221919,1.548763 5.37302642,1.71487569 5.57945975,2.12621939 C5.78589308,2.5375631 5.6197804,3.03837034 5.20843669,3.24480367 C5.12250244,3.28792987 4.94258941,3.3956806 4.70004893,3.57232501 C4.28262039,3.87634197 3.86262143,4.25832061 3.47001657,4.72207513 C2.34277449,6.05360117 1.66666667,7.77089566 1.66666667,9.94485294 C1.66666667,11.8127792 2.34596328,13.4788581 3.48843516,14.9281326 C3.89240223,15.4405822 4.32582278,15.8877512 4.75779068,16.2652218 C5.01196332,16.4873279 5.2037272,16.6332731 5.30158871,16.6994752 C5.68279258,16.957355 5.78276652,17.4754346 5.52488675,17.8566385 C5.26700698,18.2378424 4.74892733,18.3378163 4.36772346,18.0799365 C3.80185222,17.6971316 2.98920571,16.9870089 2.17955426,15.9599313 C0.821199414,14.2368 -2.4662081e-11,12.2226827 8.76356839e-16,9.94485294 C2.79705334e-11,7.3616239 0.82438821,5.26770147 2.19797285,3.64518954 C3.02870188,2.66391199 3.86761159,2.05292652 4.46087548,1.75519633 Z M14.625083,3.24480367 C14.2137393,3.03837034 14.0476266,2.5375631 14.2540599,2.12621939 C14.4604933,1.71487569 14.9613005,1.548763 15.3726442,1.75519633 C15.9659081,2.05292652 16.8048178,2.66391199 17.6355468,3.64518954 C19.0091315,5.26770147 19.8335197,7.3616239 19.8335197,9.94485294 C19.8335197,12.2226827 19.0123203,14.2368 17.6539654,15.9599313 C16.844314,16.9870089 16.0316675,17.6971316 15.4657962,18.0799365 C15.0845924,18.3378163 14.5665127,18.2378424 14.3086329,17.8566385 C14.0507532,17.4754346 14.1507271,16.957355 14.531931,16.6994752 C14.6297925,16.6332731 14.8215564,16.4873279 15.075729,16.2652218 C15.5076969,15.8877512 15.9411174,15.4405822 16.3450845,14.9281326 C17.4875564,13.4788581 18.166853,11.8127792 18.166853,9.94485294 C18.166853,7.77089566 17.4907452,6.05360117 16.3635031,4.72207513 C15.9708982,4.25832061 15.5508993,3.87634197 15.1334708,3.57232501 C14.8909303,3.3956806 14.7110172,3.28792987 14.625083,3.24480367 Z\" fill=\"none\"></path>\n" +
                        "                                </g>\n" +
                        "                            </g>\n" +
                        "\n" +
                        "                            <g class=\"d-defaultCheckmark\">\n" +
                        "                                <rect class=\"d-background\" stroke-alignment=\"inner\" fill=\"#ffffff\" x=\"0\" y=\"0\" width=\"24\" height=\"24\" rx=\"4\" ry=\"4\"></rect>\n" +
                        "                                <path class=\"d-check\" stroke-linecap=\"round\" d=\"M5,11.3L10.5 17 19 8\"></path>\n" +
                        "                            </g>\n" +
                        "                        </svg>\n" +
                        "                    </div>\n" +
                        "                </label>\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "\n" +
                        "        <!-- closed state -->\n" +
                        "    </label>\n" +
                        "    <ul aria-hidden=\"true\" class=\"d-preferences\">\n" +
                        check_list_html+
                        "    </ul>\n" +
                        "</li>";
                });

                await $('ul.d-options').html(option_info_html);


            }
        });
    };

    setInterval(updateInfo, 5000);

  </script>
@endsection