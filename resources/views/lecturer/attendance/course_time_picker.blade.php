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


{{--TODO: thẻ input--}}
<span class="time-picker">
    <label for="lesson_hours">Giờ dạy</label>
    <input type="text" name="lesson_hours" id="lesson_hours" class="text-center">
</span>
<br>

{{--Chọn giờ học--}}
<span class="time-picker" id="start" name="start">
    <span class="h5">Giờ bắt đầu:</span>
        {{--Giờ bắt đầu--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4" name="start[hour]" id="start[hour]" style="appearance: none">
            @php
                for($i = 0; $i<=24; $i++){
                    if($i < 10){
                        if($i == 8){
                            echo ("<option value='0$i' selected>0$i</option>");
                        }
                        else{
                            echo ("<option value='0$i'>0$i</option>");
                        }
                    }
                    else{
                        echo ("<option value='$i'>$i</option>");
                    }
                }
            @endphp
        </select>
        <span class="fs-4">:</span>
        {{--Phút bắt đầu--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4 fs-4 me-5" name="start[minutes]" id="start[minutes]"
                style="appearance: none">
            @php
                for($i = 0; $i<=59; $i++){
                    if($i < 10){
                        echo ("<option value='0$i'>0$i</option>");
                    }
                    else{
                        echo ("<option value='$i'>$i</option>");
                    }
                }
            @endphp
        </select>
    </span>

<span class="time-picker" id="end" name="end">
    <span class="h5">Giờ kết thúc:</span>
        {{--Giờ kết thúc--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4 fs-4" name="end[hour]" id="end[hour]" style="appearance: none">
            @php
                for($i = 0; $i<=24; $i++){
                    if($i < 10){
                        echo ("<option value='0$i'>0$i</option>");
                    }
                    else{
                        if($i == 12){
                            echo ("<option value='$i' selected>$i</option>");
                        }
                        else{
                            echo ("<option value='$i'>$i</option>");
                        }
                    }
                }
            @endphp
        </select>
        <span class="fs-4">:</span>
        {{--Phút kết thúc--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4 fs-4" name="end[minutes]" id="end[minutes]" style="appearance: none">
            @php
                for($i = 0; $i<=59; $i++){
                    if($i < 10){
                        echo ("<option value='0$i'>0$i</option>");
                    }
                    else{
                        echo ("<option value='$i'>$i</option>");
                    }
                }
            @endphp
        </select>
    </span>
