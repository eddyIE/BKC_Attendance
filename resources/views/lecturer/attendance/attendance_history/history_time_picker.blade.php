{{-- Phần chọn thời gian --}}
{{-- Nếu đang xem lại chi tiết buổi học trong phần lịch sử --}}
@isset($prevLesson)
    <span id="prev-lesson-time"></span>
    <br>
    <span class="h5">Bản ghi điểm danh buổi học ngày: </span>
    <span class="me-4 text-success fs-5 fw-bold">
        {{date('d/m/Y', strtotime($prevLesson->created_at))}}
    </span>

    {{--Nút chọn ca học--}}
    <div>
        <br>
        <span class="h5">Ca học:</span>
        @php
            if($prevLesson->shift == 0){
                echo(
                '<input id="morning-shift" type="radio" name="shift" value="0"
                class="btn-check" checked>
                <label class="btn btn-outline-primary  mb-3 ml-3" for="morning-shift">
                    Ca sáng (8h-12h)
                </label>'
                );
            } else if ($prevLesson->shift == 1){
                echo(
                '<input id="afternoon-shift" type="radio" name="shift" value="1"
                class="btn-check" checked>
                <label class="btn btn-outline-primary  mb-3 ml-3" for="afternoon-shift">
                    Ca chiều (13h-17h)
                </label>'
                );
            } else if($prevLesson->shift == 2){
                echo(
                '<input id="evening-shift" type="radio" name="shift" value="2"
                class="btn-check" checked>
                <label class="btn btn-outline-primary  mb-3 ml-3" for="evening-shift">
                    Ca tối (18h-21h)
                </label>'
                );
            }
        @endphp
        <br>
    </div>

    {{--Hiển thị giờ học--}}
<span class="time-picker">
<label for="start" class="h5 fw-normal">Giờ bắt đầu: </label>
<div class="input-group date" id="start" data-target-input="nearest">
    <input type="text" class="datetimepicker-input text-center" name="start"
           data-target="#start" value="{{$prevLesson->start}}"/>
    <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="far fa-clock"></i></div>
    </div>
</div>
</span>
<br>
<span class="time-picker">
    <label for="end" class="h5 fw-normal">Giờ kết thúc: </label>
    <div class="input-group date" id="end" data-target-input="nearest">
        <input type="text" class="datetimepicker-input text-center" name="end"
               data-target="#end" value="{{$prevLesson->end}}"/>
        <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
        </div>
    </div>
</span>
@endisset
