@extends('admin.layout.main')
@section('title', $data->name)
@section('content')
    <form action="{{ route('class.update', $data->id) }}" method="post">
        @method('PATCH')
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
                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" placeholder="Tên">
                        </div>
                        <div class="form-group">
                            <label for="program_id">Chương trình học</label>
                            @error('program_id')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <select class="form-control" name="program_id" id="program_id" size="1">
                                @foreach ($program as $each)
                                    @if($each->id == $data->program->id)
                                        <option value="{{ $each->id }}" selected>{{ $each->name }}</option>
                                    @else
                                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <p>Ngày tạo: {{ date_format($data->created_at, 'd/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="update" class="btn btn-success">Cập nhật</button>
                        <a href="{{ route('class.index') }}" class="btn btn-secondary">Quay lại</a>
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
                                            <option value="{{ $student->id }}" @if($student->selected == true) selected @endif>{{ $student->full_name }}</option>
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
