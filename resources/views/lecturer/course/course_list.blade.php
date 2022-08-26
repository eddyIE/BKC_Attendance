<table id="course_table" class="table table-striped align-middle table-bordered">
    <thead>
    <tr>
        <th class="no-sort">ID</th>
        <th class="no-sort">Tên phân công</th>
        <th class="no-sort">Giờ dự kiến</th>
        <th class="no-sort">Giờ đã dạy</th>
        <th class="no-sort">Buổi đã dạy</th>
        <th>Cập nhật lần cuối</th>
        <th class="no-sort">Hiển thị</th>
        <th class="no-sort">Tải ds thi</th>
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
                <td class="text-center">
                    <form action="{{ asset('/my-course/visibility/'.$course->id) }}" method="get">
                        @csrf
                        @if($course->status == 0)
                            <button class="btn btn-sm btn-primary" title="Khóa học chưa kết thúc">
                                <i class="fas fa-eye"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-dark" title="Khóa học đã ẩn">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        @endif
                    </form>
                </td>
                <td class="text-center">
                    <a href="{{asset('/course/export/'.$course->id)}}" class="text-primary"
                       title="Tải danh sách sinh viên đủ điều kiện thi">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    @endisset
    </tbody>
</table>
