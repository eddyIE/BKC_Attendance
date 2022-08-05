@extends('admin.layout.main')
@section('title', 'SỬA KHÓA HỌC')
@section('content')
    <div class="col-md-6">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khóa học</h3>
            </div>
            <form action="{{ route('update_course',['id' => $data[0]->id]) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên khóa học</label>
                        @error('courseName')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="courseName" value="{{ $data[0]->course }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="credit_hours">Thời lượng môn</label>
                        @error('creditHours')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="credit_hours" name="creditHours" value="{{ $data[0]->credit_hours }}" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Lớp học</label>
                                <select class="form-control" name="class">
                                    @foreach($class as $each)
                                        @if($each->name == $data[0]->class)
                                            <option value="{{ $each->id }}" selected>{{ $each->name }}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Môn học</label>
                                <select class="form-control" name="subject">
                                    @foreach($subject as $each)
                                        @if($each->name == $data[0]->subject)
                                            <option value="{{ $each->id }}" selected>{{ $each->name }}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Giảng viên</label>
                                <select class="form-control" name="lecturer">
                                    @foreach($lecturer as $each)
                                        @if($each->name == $data[0]->lecturer)
                                            <option value="{{ $each->id }}" selected>{{ $each->name }}</option>
                                        @else
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="form-control" name="type">
                                    @if($data[0]->type == 0)
                                        <option value="0" selected>Giảng viên chính</option>
                                        <option value="1">Giảng viên phụ</option>
                                    @else
                                        <option value="0">Giảng viên chính</option>
                                        <option value="1" selected>Giảng viên phụ</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('course_detail',['id' => $data[0]->id]) }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
