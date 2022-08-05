@extends('admin.layout.main')
@section('title', 'SỬA NIÊN KHÓA')
@section('content')
    <div class="col-md-4">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin niên khóa</h3>
            </div>
            <form action="{{ route('update_schoolyear',['id' => $data[0]->id]) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Mã niên khóa</label>
                        @error('codeName')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="codeName" value="{{ $data[0]->codename }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="credit_hours">Bắt đầu</label>
                        @error('start')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="number" min="1900" max="2099" step="1" class="form-control" id="credit_hours" name="start" value="{{ $data[0]->start }}" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="end">Kết thúc</label>
                        @error('end')
                        <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="number" min="1900" max="2099" step="1" class="form-control" id="end" name="end" value="{{ $data[0]->end }}" autocomplete="off">
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('schoolyear_detail',['id' => $data[0]->id]) }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
@endsection
