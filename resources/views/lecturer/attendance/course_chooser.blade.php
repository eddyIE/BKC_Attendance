{{--
    Thanh tìm kiếm và chọn lớp trên đầu trang điểm danh
--}}

@section('css')
    .select-box {
    position: relative;
    display: flex;
    width: 100%;
    flex-direction: column;
    }

    .select-box .course-container {
    background: #006182;
    color: #f5f6fa;
    max-height: 0;
    width: 100%;
    opacity: 0;
    transition: all 0.4s;
    border-radius: 8px;
    overflow: hidden;

    order: 1;
    }

    .selected {
    background: #006182;
    border-radius: 8px;
    margin-bottom: 8px;
    color: #f5f6fa;
    position: relative;

    order: 0;

    transition: all 0.4s;
    }

    .selected::after {
    content: "";
    background: url('#');
    background-size: contain;
    background-repeat: no-repeat;

    position: absolute;
    height: 100%;
    width: 32px;
    right: 10px;
    top: 7px;
    }

    .select-box .course-container.active {
    max-height: 200px;
    opacity: 1;
    overflow-y: scroll;
    margin-top: 54px;
    }

    .select-box .course-container.active+.selected::after {
    transform: rotateX(180deg);
    top: -6px;
    }

    .select-box .course-container::-webkit-scrollbar {
    width: 8px;
    background: #0d141f;
    border-radius: 0 8px 8px 0;
    }

    .select-box .course-container::-webkit-scrollbar-thumb {
    background: #006182;
    border-radius: 0 8px 8px 0;
    }

    .selected {
    padding: 12px 24px;
    cursor: pointer;
    }

    .select-box .course:hover {
    background: #414b57;
    }

    .select-box label {
    cursor: pointer;
    }

    .select-box .course .radio {
    display: none;
    }

    .select-box .course .course-label {
    width: 100%;
    height: 100%;
    padding: 12px 24px;
    cursor: pointer;
    }

    .search-box input {
    width: 100%;
    padding: 5px 12px;
    font-size: 16px;
    position: absolute;
    border-radius: 8px;
    z-index: 100;
    border: 8px solid #2f3640;

    opacity: 0;
    pointer-events: none;
    transition: all 0.4s;
    }

    .search-box input:focus {
    outline: none;
    }

    .select-box .course-container.active~.search-box input {
    opacity: 1;
    pointer-events: auto;
    }

@endsection

{{--Form chọn lớp học được phân công cho giảng viên--}}
<form action="{{ asset('/course-data') }}" method="POST" class="form">
    @csrf
    <div class="select-box">
        <div class="course-container bg-primary">
            @foreach ($courses as $course)
                <div class="course">
                    <input type="radio" class="radio" id="{{$course->id }}" name="course-id"
                           value="{{$course->id }}" required>
                    <label for="{{$course->id }}" class="course-label">{{$course->name}}</label>
                </div>
            @endforeach
        </div>
        <div class="selected bg-primary">
            CHỌN PHÂN CÔNG...
        </div>
        <div class="bg-primary search-box">
            <input type="text" placeholder="Tìm kiếm...">
        </div>
    </div>

    <input type="submit" class="btn btn-outline-primary fs-5 fw-bold fst-italic mt-2 mb-2 float-right"
           value="Lấy danh sách điểm danh"/>
</form>
