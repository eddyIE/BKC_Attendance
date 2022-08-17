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
    <input id="morning-shift" type="radio" name="shift" value="0" class="btn-check">
    <label class="btn btn-outline-primary  mb-3 ml-3" for="morning-shift">
        Ca sáng (8h-12h)
    </label>

    <input id="afternoon-shift" type="radio" name="shift" value="1" class="btn-check">
    <label class="btn btn-outline-primary  mb-3 ml-3" for="afternoon-shift">
        Ca chiều (13h-17h)
    </label>

    <input id="evening-shift" type="radio" name="shift" value="2" class="btn-check">
    <label class="btn btn-outline-primary  mb-3 ml-3" for="evening-shift">
        Ca tối (18h-21h)
    </label>
    <br>
</div>

{{--Chọn giờ học--}}

<span class="time-picker">
    <label for="lesson_hours">Giờ dạy</label>
    <div class="input-group date" id="timepicker" data-target-input="nearest">
        <input type="text" class="datetimepicker-input text-center" data-target="#timepicker" value="06:00"/>
        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
      </div>
    </div>
</span>
