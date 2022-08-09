@extends('admin.layout.main')
@section('title', $data->name)
@section('content')
    <div class="col-md-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin môn học</h3>
            </div>
            <form action="{{ route('subject.update', $data->id) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên môn học</label>
                        @error('name')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                    </div>
                    <div class="form-group">
                        <label for="recommend_hours">Thời lượng môn(dự kiến)</label>
                        @error('recommend_hours')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="recommend_hours" name="recommend_hours" value="{{ $data->recommend_hours }}">
                    </div>
                    <div class="row">
                        <p>Ngày tạo: {{ date_format($data->created_at, 'd/m/Y') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="update" class="btn btn-success">Cập nhật</button>
                    <a href="{{ route('subject.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
