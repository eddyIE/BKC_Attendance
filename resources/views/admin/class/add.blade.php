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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên">
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
            <div class="col-md-6">
                <div class="card card-olive">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-uppercase">Sinh viên</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="select2-olive">
                                <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn sinh viên" data-dropdown-css-class="select2-olive" style="width: 100%;" name="student[]" id="student">
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
