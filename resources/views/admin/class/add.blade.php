@extends('admin.layout.main')
@section('title', 'Thêm môn học')
@section('content')
    <form action="{{ route('class.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-uppercase">Thông tin môn học</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên lớp</label>
                            @error('name')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="program_id">Chương trình học</label>
                            @error('program_id')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <select class="form-control" name="program_id" id="program_id" size="1">
                                <option value="" selected disabled hidden>Chọn chương trình học</option>
                                @foreach ($program as $each)
                                    <option value="{{ $each->id }}">{{ $each->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="create" class="btn btn-success">Hoàn tất</button>
                        <a href="{{ route('subject.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#student').select2();
        });
    </script>
@endsection
