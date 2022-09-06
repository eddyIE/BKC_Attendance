{{--Phần ghi chú và các nút của trang điểm danh--}}

{{--Ghi chú--}}
<textarea class="form-control mb-4 mt-4" placeholder="Ghi chú:" name="note"
          rows="4"><?php
    echo((isset($existLesson) && $existLesson->note != '') ? $existLesson->note : '');
    ?></textarea>

{{-- <button class="btn btn-primary" data-toggle="modal" data-target="bs-example-modal-sm">Hỗ trợ</button> --}}

{{--Các nút submit--}}
@isset($students)
    <button id="submit" class="btn btn-success" type="submit">Lưu điểm danh</button>
@endisset
