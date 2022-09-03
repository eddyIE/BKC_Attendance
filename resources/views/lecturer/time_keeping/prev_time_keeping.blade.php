{{--Nút xem giờ dạy tháng trước--}}

<form target="{{ asset('/time-keeping') }}" method="GET">
    <label for="month">Xem bảng chấm công tháng khác: </label>
    <input type="month" id="month" name="month" class="form-control">
    <button type="submit" class="btn btn-outline-primary float-right">Đi</button>
</form>

