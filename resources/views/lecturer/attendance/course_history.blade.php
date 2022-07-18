{{-- Lịch sử các buổi học --}}
<button type="button" class="btn btn-primary" onclick="showPrevLesson()">Lịch sử</button>
<div class="previous-lesson border border-4 border-primary mt-2 mb-3 pe-4 pt-2 pb-4 ps-3 collapse"
     id="prev-lesson">
    Các buổi học trước: <br>
    @isset($lessons)
        @foreach ($lessons as $lesson)
            <a href="#">
                <button type="button" class="btn btn-outline-primary ms-1 me-1">
                    @php
                        echo date('d-m-Y', strtotime($lesson->created_at));
                    @endphp
                </button>
            </a>
        @endforeach
    @endisset
</div>
<br>