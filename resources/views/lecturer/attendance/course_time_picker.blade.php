{{--Chọn giờ học cho bản điểm danh mới--}}
<span class="h5"> Ngày điểm danh: </span>
<input type="date" name='lesson-date'
       class='pt-1 pb-1 text-primary fs-5 text-center'
       value="<?php echo date('Y-m-d'); ?>"
       placeholder="dd-mm-yyyy" readonly>

{{--Nút chọn ca học--}}
<div>
    <br>
    <span class="h5">Ca học:</span>
    @if(isset($existLesson) && $existLesson->shift == 0)
        <input id="morning-shift" type="radio" name="shift" value="0" class="btn-check" checked>
    @else
        <input id="morning-shift" type="radio" name="shift" value="0" class="btn-check" required>
    @endif
    <label class="btn btn-outline-primary  mb-3 ml-3" for="morning-shift">
        Ca sáng (8h-12h)
    </label>

    @if(isset($existLesson) && $existLesson->shift == 1)
        <input id="afternoon-shift" type="radio" name="shift" value="1" class="btn-check" checked>
    @else
        <input id="afternoon-shift" type="radio" name="shift" value="1" class="btn-check">
    @endif

    <label class="btn btn-outline-primary  mb-3 ml-3" for="afternoon-shift">
        Ca chiều (13h-17h)
    </label>

    @if(isset($existLesson) && $existLesson->shift == 2)
        <input id="evening-shift" type="radio" name="shift" value="2" class="btn-check" checked>
    @else
        <input id="evening-shift" type="radio" name="shift" value="2" class="btn-check">
    @endif
    <label class="btn btn-outline-primary  mb-3 ml-3" for="evening-shift">
        Ca tối (18h-21h)
    </label>
    <br>
</div>

<span class="time-picker">
    <label for="start" class="h5 fw-normal">Giờ bắt đầu: </label>
    <div class="input-group date" id="start" data-target-input="nearest">
        <input type="text" class="datetimepicker-input text-center" name="start"
               data-target="#start" value="{{isset($existLesson) ? $existLesson->start : "08:00"}}"/>
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
               data-target="#end" value="{{isset($existLesson) ? $existLesson->end : "12:00"}}"/>
        <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
        </div>
    </div>
</span>
<br>


