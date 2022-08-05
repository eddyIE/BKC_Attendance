@extends('admin.layout.main')
@section('title', $data->full_name)
@section('content')
    <div class="col-md-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin sinh viên</h3>
            </div>
            <form action="{{ route('student.update', $data->id) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="full_name">Họ & tên</label>
                        @error('full_name')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $data->full_name }}">
                    </div>
                    <div class="form-group">
                        <label for="major_id">Lớp</label>
                        @error('class_id')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <select class="form-control" name="class_id" id="class_id" size="1">
                            <option value="" selected disabled hidden>Chọn lớp học</option>
                            @foreach ($class as $each)
                                @if($each->id == $data->class->id)
                                    <option value="{{ $each->id }}" selected>{{ $each->name }}</option>
                                @else
                                    <option value="{{ $each->id }}">{{ $each->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Ngày sinh</label>
                        @error('birthdate')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="birthdate" name="birthdate" value="{{ date('d/m/Y', strtotime($data->birthdate)) }}">
                    </div>
                    <div class="row">
                        <p>Ngày tạo: {{ date_format($data->created_at, 'd/m/Y') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="update" class="btn btn-success">Cập nhật</button>
                    <a href="{{ route('student.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function (){
            $('#birthdate').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD/MM/YYYY'
                },
            });
        });
    </script>
@endsection
