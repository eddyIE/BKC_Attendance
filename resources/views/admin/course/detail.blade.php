@extends('admin.layout.main')
@section('title', 'CHI TIẾT KHÓA HỌC')
@section('content')
    <div class="col-md-6">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khóa học</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $message)
                            {{ $message }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="form-group">
                    <label for="name">Tên khóa học</label>
                    <input type="text" class="form-control" id="name" name="courseName" value="{{ $data[0]->course }}"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="credit_hours">Thời lượng môn</label>
                    <input type="text" class="form-control" id="credit_hours" name="creditHours"
                        value="{{ $data[0]->credit_hours }}" disabled>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Lớp học</label>
                            <select class="form-control" name="class" disabled>
                                <option selected>{{ $data[0]->class }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Môn học</label>
                            <select class="form-control" name="subject" disabled>
                                <option selected>{{ $data[0]->subject }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Giảng viên</label>
                            <select class="form-control" name="lecturer" disabled>
                                <option selected>{{ $data[0]->lecturer }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="type" disabled>
                                @if ($data[0]->type == 0)
                                    <option selected>Giảng viên chính</option>
                                @else
                                    <option selected>Giảng viên phụ</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p>Ngày tạo khóa học: {{ $data[0]->cre_date }}</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('edit_course', ['id' => $data[0]->id]) }}" class="btn btn-primary">Sửa</a>
                <a href="{{ route('delete_course', ['id' => $data[0]->id]) }}" class="btn btn-danger">Xóa</a>
                <a href="{{ route('course') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
