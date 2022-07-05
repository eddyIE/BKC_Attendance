{{--
    Danh sách điểm danh của khóa học
--}}
<table id="example1" class="table table-striped align-middle table-bordered">
    <thead>
    <tr class="bg-dark">
        <th td class="text-center fs-5 text-white">STT</th>
        <th class="fs-5 text-white">Tên sinh viên</th>
        <th td class="text-center fs-5 text-white" colspan="4">Điểm danh</th>
        <th class="fs-5 text-white">Ghi chú</th>
    </tr>
    </thead>
    <tbody>
    @isset($students)
        @foreach ($students as $each)
            <tr>
                <input type="hidden" name="students[{{ $loop->index + 1 }}][student_id]"
                       value="{{ $each->id }}"/>

                {{--Số thứ tự--}}
                <td class="text-center">{{ $loop->index + 1 }}</td>

                {{--Thông tin chung một sinh viên: Tên, ngày sinh, số nghỉ, số phép--}}
                <td class="">
                    {{--Tên sinh viên--}}
                    <span class="roll fw-bolder"><a href="#">{{ $each->full_name }}</a></span>

                    {{--Số buổi nghỉ / Tổng số buổi đã học--}}
                    <span class="text-danger fw-bold">
                        ({{ $each->absentQuan }}
                        /
                        <?php echo isset($curCourse) ? $curCourse->{'finished_lesson'} + 1 : ''; ?>)
                    </span>

                    {{--Số buổi nghỉ có phép--}}
                    <span class="fw-bold fst-italic"> - P:{{ $each->permissionQuan }}</span>
                    <br>

                    {{--Ngày sinh--}}
                    <span class="roll fw-lighter fst-italic">
                        @php
                            echo '(' . date('d-m-Y', strtotime($each->birthdate)) . ')';
                        @endphp
                    </span>
                </td>

                {{--Các option điểm danh--}}
                {{--Có mặt--}}
                <td class="text-center border border-0">
                    <input type="radio" class="btn-check"
                           name="students[{{ $loop->index + 1 }}][status]" value=""
                           id="{{$each->id}}_attend" checked>
                    <label class="btn btn-outline-success" for="{{$each->id}}_attend">
                        Có mặt
                    </label>
                </td>
                {{--Nghỉ không phép--}}
                <td class="text-center border border-0">
                    <input type="radio" class="btn-check"
                           name="students[{{ $loop->index + 1 }}][status]" value="without reason"
                           id="{{$each->id}}_no_reason"
                        {{ $each->currentStatus == 'without reason' ? ' checked' : '' }}>
                    <label class="btn btn-outline-danger" for="{{$each->id}}_no_reason">
                        Nghỉ
                    </label>
                </td>

                {{--Đi muộn--}}
                <td class="text-center border border-0">
                    <input type="radio" class="btn-check"
                           name="students[{{ $loop->index + 1 }}][status]" value="late"
                           id="{{$each->id}}_late" {{ $each->currentStatus == 'late' ? ' checked' : '' }}>
                    <label class="btn btn-outline-dark" for="{{$each->id}}_late">
                        Muộn
                    </label>
                </td>

                {{--Nghỉ có phép--}}
                <td class="text-center border border-0">
                    <input type="radio" class="btn-check"
                           name="students[{{ $loop->index + 1 }}][status]" id="{{$each->id}}_with_reason"
                           autocomplete="off" value="with reason"
                        {{ $each->currentStatus == 'with reason' ? ' checked' : '' }}>
                    <label class="btn btn-outline-primary" for="{{$each->id}}_with_reason">
                        Có phép
                    </label>
                </td>

                {{--Ghi chú--}}
                <td>
                    <input type="text" class="form-control"
                           name="students[{{ $loop->index + 1 }}][absent_reason]"
                           id="{{$each->id}}_absent_reason" placeholder="Lý do nghỉ (nếu có)"
                           value="{{ $each->absentReason }}" ?>
                </td>
            </tr>
        @endforeach
    @endisset
    </tbody>
</table>
