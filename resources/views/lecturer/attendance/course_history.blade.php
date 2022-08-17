{{-- Lịch sử các buổi học trước --}}
<button type="button" class="btn btn-primary" onclick="showPrevLesson()">Lịch sử</button>
<div class="previous-lesson border border-4 border-primary mt-2 mb-3 pe-4 pt-2 pb-4 ps-3 collapse"
     id="prev-lesson">
    Các buổi học trước: <br>
    @isset($lessons)
        @foreach ($lessons as $lesson)
            <a href="{{ asset('lesson/'.$lesson->id) }}">
                <button type="button" class="btn btn-outline-primary ms-1 me-1 mb-1 mt-1"
                style="min-width: 200px">
                    @php
                        $shift = "";
                        if($lesson->shift == 0){
                            $shift = "Ca sáng";
                        }
                        else if($lesson->shift == 1){
                            $shift = "Ca chiều";
                        }
                        else if($lesson->shift == 2){
                            $shift = "Ca tối";
                        }
                        // Hiển thị button có nội dung dạng: Ca sáng - 1/1/2022
                        echo ($shift." - ".date('d/m/Y', strtotime($lesson->created_at)));
                    @endphp
                </button>
            </a>
        @endforeach
    @endisset
</div>
<br>
