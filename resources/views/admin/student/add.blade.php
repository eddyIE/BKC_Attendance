@extends('admin.layout.main')
@section('title', 'Thêm sinh viên')
@section('content')
    <div class="col-md-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin sinh viên</h3>
            </div>
            <form action="{{ route('student.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="code">Mã sinh viên</label>
                        @error('code')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="code" name="code">
                    </div>
                    <div class="form-group">
                        <label for="full_name">Họ & tên</label>
                        @error('full_name')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group">
                        <label for="class_id">Lớp</label>
                        @error('class_id')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <select class="form-control" name="class_id" id="class_id" size="1">
                            <option value="" selected disabled hidden>Chọn lớp học</option>
                            @foreach ($class as $each)
                                <option value="{{ $each->id }}">{{ $each->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Ngày sinh</label>
                        @error('birthdate')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="birthdate" name="birthdate">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="create" class="btn btn-success">Hoàn tất</button>
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
