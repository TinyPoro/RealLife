@extends('templates.nbs-template')

@section('after-css')
    <link href="{{url('css/create.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- multistep form -->
    <form id="msform">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">Nhập thông tin sự kiện</li>
            <li>Thêm các lựa chọn</li>
            <li>Xuất bản lựa chọn</li>
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
            <h2 class="fs-title">Social Profiles</h2>
            <h3 class="fs-subtitle">Your presence on the social network</h3>
            <input type="text" name="twitter" placeholder="Twitter" />
            <input type="text" name="facebook" placeholder="Facebook" />
            <input type="text" name="gplus" placeholder="Google Plus" />
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Personal Details</h2>
            <h3 class="fs-subtitle">We will never sell it</h3>
            <input type="text" name="fname" placeholder="First Name" />
            <input type="text" name="lname" placeholder="Last Name" />
            <input type="text" name="phone" placeholder="Phone" />
            <textarea name="address" placeholder="Address"></textarea>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>
    </form>
@endsection

@section('after-scripts')
    <script src="{{url('js/create.js')}}"></script>
@endsection
