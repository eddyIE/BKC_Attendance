{{--Phần ghi chú và các nút của trang điểm danh--}}

{{--Ghi chú--}}
<textarea class="form-control mb-4 mt-4" placeholder="Ghi chú:" name="note"
          rows="4">
    <?php
    echo isset($lessonNote) && $lessonNote != '' ? $lessonNote : '';
    ?>
</textarea>

{{-- <button class="btn btn-primary" data-toggle="modal" data-target="bs-example-modal-sm">Hỗ trợ</button> --}}

{{--Các nút submit--}}
@isset($students)
    {{--Các nút khi đang xem lịch sử--}}
    @isset($curLessonDate)
        <button id="submit" class="btn btn-success mb-3" type="submit">Cập nhật điểm danh</button>
        </form>
        <form action="{{ route('course_attendance') }}" method="POST">
            @csrf
            <input type="hidden" name='course-id' value='{{$curCourse->id}}'>
            <button id="" class="btn btn-primary" type="">
                Trở về buổi học hiện tại
            </button>
        </form>
    {{--Các nút khi không ở chế độ xem lịch sử--}}
    @else
        <button id="submit" class="btn btn-success" type="submit">Lưu điểm danh</button>
    @endisset
@endisset
