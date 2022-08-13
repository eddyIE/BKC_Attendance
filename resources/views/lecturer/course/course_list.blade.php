<table id="example1" class="table table-striped align-middle table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Tên phân công</th>
        <th>Số giờ dự kiến</th>
        <th>Số giờ đã dạy</th>
        <th>Số buổi đã dạy</th>
        <th>Lần cập nhật gần nhất</th>
        <th>Trạng thái khóa học</th>
    </tr>
    </thead>
    <tbody>
    @isset($courses)
        @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->total_hours }}</td>
                <td>{{ $course->finished_hours }}</td>
                <td>{{ $course->finished_lessons }}</td>
                <td>{{ date('h:i:s - d/m/Y', strtotime($course->updated_at)) }}</td>
                <td>
                    <form action="{{ asset('/my-course/visibility/'.$course->id) }}" method="get">
                        @csrf
                        @if($course->status == 0)
                            <button class="btn btn-sm btn-info" title="Khóa học chưa kết thúc">
                                <i class="fas fa-eye"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-dark" title="Khóa học đã ẩn">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
    @endisset
    </tbody>
</table>
