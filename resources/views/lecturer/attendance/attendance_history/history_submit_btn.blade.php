{{--Phần ghi chú và các nút của trang điểm danh--}}

{{--Ghi chú--}}
<textarea class="form-control mb-4 mt-4" placeholder="Ghi chú:" name="note"
          rows="3"><?php
    echo((isset($prevLesson) && $prevLesson->note != '') ? $prevLesson->note : '');
    ?></textarea>

{{-- <button class="btn btn-primary" data-toggle="modal" data-target="bs-example-modal-sm">Hỗ trợ</button> --}}

{{--Các nút submit--}}
@isset($students)
    {{--Các nút khi đang xem lịch sử--}}
    @isset($prevLesson)
        <input type="hidden" name="prev-lesson-id" value="{{$prevLesson->id}}">
        <button id="submit" class="btn btn-success mb-3" type="submit">
            Cập nhật điểm danh
        </button>
    @endisset
@endisset
