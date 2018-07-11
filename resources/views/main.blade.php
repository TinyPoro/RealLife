@extends('templates.template')

@section('content')
    <div class="content" >
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xs-12 col-md-8">
                    <div class="pull-left" ><a href="#" class="prevnext"><i class="fa fa-angle-left"></i></a></div>
                    <div class="pull-left">
                        <ul class="paginationforum">
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li class="hidden-xs"><a href="#">5</a></li>
                            <li class="hidden-xs"><a href="#">6</a></li>
                            <li class="hidden-xs"><a href="#">7</a></li>
                            <li class="hidden-xs"><a href="#">8</a></li>
                            <li class="hidden-xs"><a href="#">9</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">10</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">11</a></li>
                            <li class="hidden-xs hidden-md"><a href="#">12</a></li>
                            <li class="hidden-xs hidden-sm hidden-md"><a href="#">13</a></li>
                        </ul>
                    </div>
                    <div class="pull-left"><a href="#" class="prevnext last"><i class="fa fa-angle-right"></i></a></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    @foreach($events as $event)
                    <!-- POST -->
                        <div class="post">
                            <div class="wrap-ut pull-left">
                                <div class="userinfo pull-left">
                                    <div class="avatar">
                                        <img src="{{$event->picture}}" style="width: 40px;height: auto" alt="">
                                        <div class="status green">&nbsp;</div>
                                    </div>

                                    <div class="icons">
                                        <img src="{{url('img/icon1.jpg')}}" alt=""><img src="{{url('img/icon4.jpg')}}" alt="">
                                    </div>
                                </div>
                                <div class="posttext pull-left">
                                    <h2><a href="">{{$event->title}}</a></h2>
                                    <p>{{$event->description}}</p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="postinfo pull-left">
                                <div class="comments">
                                    <div class="commentbg">
                                        {{count($event->options)}}
                                        <div class="mark"></div>
                                    </div>

                                </div>
                                <div class="views"><i class="fa fa-play"></i> {{$event->start}}</div>
                                <div class="time"><i class="fa fa-clock-o"></i> {{$event->end}}</div>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- POST -->
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-4">

                    <!-- -->
                    <div class="sidebarblock">
                        <h3>Các sự kiện mới</h3>
                        <div class="divline"></div>
                        <div class="blocktxt">
                            <ul class="hot_events">
                                @foreach($hot_events as $hot_event)
                                    <li><a href="#">{{$hot_event->title}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
