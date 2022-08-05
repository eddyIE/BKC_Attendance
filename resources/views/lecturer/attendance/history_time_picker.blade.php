{{-- Phần chọn thời gian --}}
{{-- Nếu đang xem lại chi tiết buổi học trong phần lịch sử --}}
@isset($prevLesson)
    <span class="h5">Ngày điểm danh buổi học này: </span>
    <input type="text" name='lesson-date'
           class='pt-2 pb-2 ps-2 mb-2 me-4 text-success fs-5 text-center'
           value="{{date('d/m/Y', strtotime($prevLesson->created_at))}}"
           placeholder="dd-mm-yyyy" readonly>

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
    <span class="time-picker" id="start" name="start">
    <span class="h5">Giờ bắt đầu:</span>
        {{--Giờ bắt đầu--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4" name="start[hour]" id="start[hour]"
                style="appearance: none" readonly>
            <option value='{{explode(':', $prevLesson->start)[0]}}' selected>
                {{explode(':', $prevLesson->start)[0]}}
            </option>
        </select>
        <span class="fs-4">:</span>
        {{--Phút bắt đầu--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4 fs-4 me-5" name="start[minutes]" id="start[minutes]"
                style="appearance: none" readonly>
            <option value='{{explode(':', $prevLesson->start)[1]}}' selected>
                {{explode(':', $prevLesson->start)[1]}}
            </option>
        </select>
    </span>

    <span class="time-picker" id="end" name="end">
    <span class="h5">Giờ kết thúc:</span>
        {{--Giờ kết thúc--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4" name="end[hour]" id="end[hour]"
                style="appearance: none" readonly>
            <option value='{{explode(':', $prevLesson->end)[0]}}' selected>
                {{explode(':', $prevLesson->end)[0]}}
            </option>
        </select>
        <span class="fs-4">:</span>
        {{--Phút kết thúc--}}
        <select class="pt-1 pb-1 ps-3 pe-3 fs-4 fs-4" name="end[minutes]" id="end[minutes]"
                style="appearance: none" readonly>
            <option value='{{explode(':', $prevLesson->end)[1]}}' selected>
                {{explode(':', $prevLesson->end)[1]}}
            </option>
        </select>
    </span>
@endisset
