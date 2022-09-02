{{--Chọn giờ học cho bản điểm danh mới--}}

{{--Hiển thị lịch dự kiến của lớp môn học--}}
<table title="Lịch môn này" class="table table-bordered">
    <tr>
        <th colspan="8" class="fs-5">Lịch lớp môn học</th>
    </tr>
    <tr>
        <td>Ngày</td>
        @php
            // Đã check isset trong index.blade.php
            $scheduled_days = str_replace("[", "", $curCourse->scheduled_day);
            $scheduled_days = str_replace("]", "", $scheduled_days);
            $scheduled_days = explode(",", $scheduled_days);
            $weekDayVietnamese = ["CHỦ NHẬT",
             "THỨ HAI",
             "THỨ BA",
             "THỨ TƯ",
             "THỨ NĂM",
             "THỨ SÁU",
             "THỨ BẢY"];
        @endphp
        @foreach($scheduled_days as $day)
            <td>{{$weekDayVietnamese[$day]}}</td>
        @endforeach
    </tr>
    <tr>
        <td>Thời gian</td>
        <td colspan="7" class="text-center">{{$curCourse->scheduled_time}}</td>
    </tr>
</table>

<div class="text-info mt-4 mb-4">
    - Ca sáng: 8-12h | Ca chiều: 13-17h | Ca tối: 18-21h <br>
    - Giờ bắt đầu không sớm hơn hiện tại <br>
    - Không điểm danh sau khi buổi học kết thúc quá 30p
</div>

<label for="lesson-date" class="h5 text-primary fw-normal">
    Ngày điểm danh:
</label>
<input type="date" name='lesson-date' id="lesson-date"
       class='pt-1 pb-1 text-primary fs-5 text-center'
       value="<?php echo date('Y-m-d'); ?>"
       placeholder="dd-mm-yyyy" readonly>

<br>
{{--Nút chọn ca học--}}
<div>
    <br>
    @if(isset($existLesson))
        <span class="h5">Ca học:</span>
        @if($existLesson->shift == 0)
            <input id="morning-shift" type="radio" name="shift" value="0" class="btn-check" checked>
            <label class="btn btn-outline-primary  mb-3 ml-3" for="morning-shift">
                Ca sáng (8h-12h)
            </label>

        @elseif($existLesson->shift == 1)
            <input id="afternoon-shift" type="radio" name="shift" value="1" class="btn-check" checked>

            <label class="btn btn-outline-primary  mb-3 ml-3" for="afternoon-shift">
                Ca chiều (13h-17h)
            </label>

        @elseif($existLesson->shift == 2)
            <input id="evening-shift" type="radio" name="shift" value="2" class="btn-check" checked>
            <label class="btn btn-outline-primary  mb-3 ml-3" for="evening-shift">
                Ca tối (18h-21h)
            </label>
            <br>
        @endif
        <input id="shift" type="hidden" name="shift">
    @else
        <input id="shift" type="hidden" name="shift">
    @endif
</div>

<div class="row mb-3">
    <span class="time-picker col justify-content-center">
        <label for="start" class="h5 fw-normal">Giờ bắt đầu: </label>
        <div class="input-group date" id="start" data-target-input="nearest">
            <input type="text" class="datetimepicker-input text-center" name="start"
                   data-target="#start" value="08:00"/>
            <div class="input-group-append" data-target="#start" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-clock"></i></div>
            </div>
        </div>
    </span>
    <span class="time-picker col justify-content-center">
        <label for="end" class="h5 fw-normal">Giờ kết thúc: </label>
        <div class="input-group date" id="end" data-target-input="nearest">
            <input type="text" class="datetimepicker-input text-center" name="end"
                   data-target="#end" value="12:00"/>
            <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-clock"></i></div>
            </div>
        </div>
    </span>
</div>


