<li class="d-option" data-cid="c140" data-optionindex="0">
    <label class="d-headerGroup" for="d-participantPreference-c153-0">
        <div class="d-optionDate">
            <div class="d-dateGroup">
                {{$option->content}}
            </div>
        </div>
        <div class="d-optionDetails">

            <div class="d-participantCount d-bestOption">
                <button aria-label="1 vote. See participants preferences" aria-haspopup="true" type="button" class="d-button d-countButton d-medium d-silentButton">
                    <div class="d-buttonContainer">
                        <div class="d-buttonContent">
                            <div class="d-textContainer">
                                <div class="d-text">
                                    {{count($option->users)}}
                                    @if(count($users) != 0)
                                        ({!! number_format((count($option->users) * 100 / count($users)), 2) !!}%)
                                    @else
                                    (0%)
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="d-buttonState">
                        </div>
                    </div>
                </button>

                <button aria-label="1 vote. See participants preferences" aria-haspopup="true" type="button" class="d-button d-verboseCountButton d-medium d-silentButton">
                    <div class="d-buttonContainer">
                        <div class="d-buttonContent">

                            <div class="d-textContainer">
                                <div class="d-text">1 vote</div>
                            </div>

                        </div>
                        <div class="d-buttonState">
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <!-- closing state -->
        <div id="" class="d-checkbox d-participantPreference d-noPreference" data-optionindex="0" data-participant-id="c153">
            <div class="d-checkboxWrapper">
                <input aria-label=" " type="checkbox" id="d-participantPreference-c153-{{$option->id}}" value="{{$option->id}}" name="d-participantPreference-c153-{{$option->id}}">
                <label for="d-participantPreference-c153-{{$option->id}}">
                    <div class="d-checkmarkWrapper">
                        <svg class="d-checkmark" viewBox="0 0 24 24" fill="currentColor">
                            <defs>
                                <clipPath id="badgeClip">
                                    <path d="M13.2463013,-0.999999989 L-1,-0.999999989 L-1,25.003591 L25,25.003591 L25,7.21957071 C20.5747645,7.84262556 16.0533842,5.37951456 12.7409797,-0.19061816 C12.9064595,-0.468116667 13.0749566,-0.737911095 13.2463082,-1 Z"></path>
                                </clipPath>
                            </defs>


                            <!-- order is important - ifNeedBe should be rendered below the default checkmark -->
                            <g class="d-ifNeedBeCheckmark">
                                <rect class="d-background" stroke-alignment="inner" fill="#ffffff" x="0" y="0" width="24" height="24" rx="4" ry="4"></rect>
                                <g transform="translate(2 2)">
                                    <path class="d-check" d="M5.92595894,8.73939407 L8.54659942,11.6292341 L14.127404,6.18830469 C14.6217147,5.70638324 15.4131072,5.71642669 15.8950286,6.21073736 C16.3769501,6.70504803 16.3669066,7.49644052 15.872596,7.97836197 L8.43587461,15.2286921 L4.07404106,10.4187988 C3.61028626,9.90740578 3.64890465,9.11689229 4.16029765,8.65313748 C4.67169065,8.18938268 5.46220413,8.22800107 5.92595894,8.73939407 Z M4.46087548,1.75519633 C4.87221919,1.548763 5.37302642,1.71487569 5.57945975,2.12621939 C5.78589308,2.5375631 5.6197804,3.03837034 5.20843669,3.24480367 C5.12250244,3.28792987 4.94258941,3.3956806 4.70004893,3.57232501 C4.28262039,3.87634197 3.86262143,4.25832061 3.47001657,4.72207513 C2.34277449,6.05360117 1.66666667,7.77089566 1.66666667,9.94485294 C1.66666667,11.8127792 2.34596328,13.4788581 3.48843516,14.9281326 C3.89240223,15.4405822 4.32582278,15.8877512 4.75779068,16.2652218 C5.01196332,16.4873279 5.2037272,16.6332731 5.30158871,16.6994752 C5.68279258,16.957355 5.78276652,17.4754346 5.52488675,17.8566385 C5.26700698,18.2378424 4.74892733,18.3378163 4.36772346,18.0799365 C3.80185222,17.6971316 2.98920571,16.9870089 2.17955426,15.9599313 C0.821199414,14.2368 -2.4662081e-11,12.2226827 8.76356839e-16,9.94485294 C2.79705334e-11,7.3616239 0.82438821,5.26770147 2.19797285,3.64518954 C3.02870188,2.66391199 3.86761159,2.05292652 4.46087548,1.75519633 Z M14.625083,3.24480367 C14.2137393,3.03837034 14.0476266,2.5375631 14.2540599,2.12621939 C14.4604933,1.71487569 14.9613005,1.548763 15.3726442,1.75519633 C15.9659081,2.05292652 16.8048178,2.66391199 17.6355468,3.64518954 C19.0091315,5.26770147 19.8335197,7.3616239 19.8335197,9.94485294 C19.8335197,12.2226827 19.0123203,14.2368 17.6539654,15.9599313 C16.844314,16.9870089 16.0316675,17.6971316 15.4657962,18.0799365 C15.0845924,18.3378163 14.5665127,18.2378424 14.3086329,17.8566385 C14.0507532,17.4754346 14.1507271,16.957355 14.531931,16.6994752 C14.6297925,16.6332731 14.8215564,16.4873279 15.075729,16.2652218 C15.5076969,15.8877512 15.9411174,15.4405822 16.3450845,14.9281326 C17.4875564,13.4788581 18.166853,11.8127792 18.166853,9.94485294 C18.166853,7.77089566 17.4907452,6.05360117 16.3635031,4.72207513 C15.9708982,4.25832061 15.5508993,3.87634197 15.1334708,3.57232501 C14.8909303,3.3956806 14.7110172,3.28792987 14.625083,3.24480367 Z" fill="none"></path>
                                </g>
                            </g>

                            <g class="d-defaultCheckmark">
                                <rect class="d-background" stroke-alignment="inner" fill="#ffffff" x="0" y="0" width="24" height="24" rx="4" ry="4"></rect>
                                <path class="d-check" stroke-linecap="round" d="M5,11.3L10.5 17 19 8"></path>
                            </g>
                        </svg>
                    </div>
                </label>
            </div>
        </div>

        <!-- closed state -->
    </label>
    <ul aria-hidden="true" class="d-preferences">
        @foreach($check_list[$option->id] as $check)
            @if($check == 1)
                <li class=" d-yesPreference d-preference" data-participant-id="199552085">
                    <i class="fa fa-check" style="color:#87C627;" aria-hidden="true"></i>
                </li>
            @else
                <li class=" d-noPreference d-preference" data-participant-id="224514269">

                </li>
            @endif
        @endforeach
    </ul>
</li>