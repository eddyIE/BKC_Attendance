@isset($students)
    @isset($prevLesson)
        <form action="{{ asset('/course-data') }}" method="POST">
            @csrf
            <input type="hidden" name='course-id' value='{{$curCourse->id}}'>
            <button id="" class="btn btn-primary" type="submit">
                Trở về buổi học hiện tại
            </button>
        </form>
    @endisset
@endisset
