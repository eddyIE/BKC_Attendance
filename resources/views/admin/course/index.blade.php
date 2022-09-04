@extends('admin.layout.main')
@section('title', 'Khóa học')
@section('content')
    <div class="row form-group">
        <div class="col-md-3 offset-9 text-right">
            <a class="btn btn-primary" href="{{ route('course.create') }}">Tạo mới</a>
        </div>
    </div>
    <table id="datatable" class="table align-middle table-bordered">
        <thead>
            <tr class="bg-dark">
                <th class="fs-5 text-white text-center border-0">STT</th>
                <th class="fs-5 text-white text-center border-0">Lớp</th>
                <th class="fs-5 text-white text-center border-0">Môn</th>
                <th class="fs-5 text-white text-center border-0">Thời lượng môn</th>
                <th class="fs-5 text-white text-center border-0">Giảng viên</th>
                <th class="fs-5 text-white text-center border-0">Ngày tạo</th>
                <th class="fs-5 text-white text-center border-0"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $each)
                @if($each->status == 1)
                    <tr class="clickable-row" onclick="window.location='{{ route('course.show', $each->id) }}'">
                        <td class="text-center border-0">{{ $loop->index + 1 }}</td>
                        <td class="text-center border-0">{{ $each->class->name }}</td>
                        <td class="text-center border-0">{{ $each->program_info->subject->name }}</td>
                        <td class="text-center border-0">{{ (float) $each->total_hours . ' giờ' }}</td>
                        @if(isset($each->lecturer_scheduling[0]))
                            @if($each->lecturer_scheduling[0]->substitution == 0)
                                <td class="text-center border-0">{{ $each->lecturer_scheduling[0]->user->full_name }}</td>
                            @else
                                <td class="text-center border-0">{{ $each->lecturer_scheduling[0]->user->full_name . ' (dạy thay)' }}</td>
                            @endif
                        @else
                            <td class="text-center border-0 text-danger">Chưa phân công</td>
                        @endif
                        <td class="text-center border-0">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                        <td class="border-0 align-middle text-center">
                            <form action="{{ route('course.destroy', $each->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @else
                    <tr class="clickable-row table-active" onclick="window.location='{{ route('course.show', $each->id) }}'">
                        <td class="text-center border-0">{{ $loop->index + 1 }}</td>
                        <td class="text-center border-0">{{ $each->class->name }}</td>
                        <td class="text-center border-0">{{ $each->program_info->subject->name }}</td>
                        <td class="text-center border-0">{{ (float) $each->total_hours . ' giờ' }}</td>
                        @if($each->lecturer_scheduling[0]->substitution == 0)
                            <td class="text-center border-0">{{ $each->lecturer_scheduling[0]->user->full_name }}</td>
                        @else
                            <td class="text-center border-0">{{ $each->lecturer_scheduling[0]->user->full_name . ' (dạy thay)' }}</td>
                        @endif
                        <td class="text-center border-0">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                        <td class="border-0 align-middle text-center">
                            <form action="{{ route('course.restore', $each->id) }}" method="post">
                                @method('PATCH')
                                @csrf
                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-redo"></i></button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
