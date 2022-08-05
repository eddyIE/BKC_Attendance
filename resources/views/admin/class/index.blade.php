@extends('admin.layout.main')
@section('title', 'Lớp học')
@section('content')
    <div class="row form-group">
        <div class="col-md-3 offset-9 text-right">
            <a class="btn btn-primary" href="{{ route('class.create') }}">Tạo mới</a>
        </div>
    </div>
    <table id="datatable" class="table align-middle table-bordered">
        <thead>
            <tr class="bg-dark">
                <th class="fs-5 border-0 text-white text-center">#</th>
                <th class="fs-5 border-0 text-white">Tên</th>
                <th class="fs-5 border-0 text-white text-center">Chương trình</th>
                <th class="fs-5 border-0 text-white text-center">Ngày tạo</th>
                <th class="fs-5 border-0 text-white text-center"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $each)
            @if($each->status == 1)
                <tr class="clickable-row" onclick="window.location='{{ route('class.show', $each->id) }}'">
                    <td class="text-center border-0">{{ $loop->index + 1 }}</td>
                    <td class="border-0">{{ $each->name }}</td>
                    <td class="text-center border-0">{{ $each->program->name }}</td>
                    <td class="border-0 align-middle text-center">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                    <td class="border-0 align-middle text-center">
                        <form action="{{ route('class.destroy', $each->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @else
                <tr class="clickable-row table-active" onclick="window.location='{{ route('class.show', $each->id) }}'">
                    <td class="text-center border-0">{{ $loop->index + 1 }}</td>
                    <td class="border-0">{{ $each->name }}</td>
                    <td class="text-center border-0">{{ $each->program->name }}</td>
                    <td class="border-0 align-middle text-center">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                    <td class="border-0 align-middle text-center">
                        <form action="{{ route('class.restore', $each->id) }}" method="post">
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
