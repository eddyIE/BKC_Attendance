@extends('admin.layout.main')
@section('title', 'SỬA MÔN HỌC')
@section('content')
    <div class="col-md-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin môn học</h3>
            </div>
            <form action="{{ route('update_subject',['id' => $data[0]->id]) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên môn học</label>
                        @error('subjectName')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="subjectName" value="{{ $data[0]->name }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="credit_hours">Thời lượng môn (dự kiến)</label>
                        @error('totalHours')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="credit_hours" name="totalHours" value="{{ $data[0]->total_hours }}" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('subject_detail',['id' => $data[0]->id]) }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
