@extends('admin.layout.main')
@section('title', $data->name)
@section('content')
    <div class="col-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khoa</h3>
            </div>
            <form action="{{ route('major.update', $data->id) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                    </div>
                    <div class="form-group">
                        <label for="credit_hours">Mã</label>
                        <input type="text" class="form-control" id="credit_hours" name="codeName" value="{{ $data->codeName }}">
                    </div>
                    <div class="time">
                        <p>Ngày tạo: {{ date_format($data->created_at, 'd/m/Y') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Cập nhật">
                    <a href="{{ route('major.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
