@extends('admin.layout.main')
@section('title', 'Thêm chương trình học ')
@section('content')

    <form action="{{ route('program.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-uppercase">Thông tin chương trình học</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên</label>
                            @error('name')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Tên">
                        </div>
                        <div class="form-group">
                            <label for="major_id">Chuyên ngành</label>
                            @error('major_id')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <select class="form-control" name="major_id" id="major_id" size="1">
                                <option value="" selected disabled hidden>Chọn chuyên ngành</option>
                                @foreach ($majors as $major)
                                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="session">Niên khóa</label>
                            @error('session')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <input type="text" class="form-control" id="session" name="session" autocomplete="off" placeholder="Niên khóa">
                        </div>
                        <div class="form-group">
                            <label for="start">Năm học</label>
                            @error('date_range')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" name="date_range" class="form-control float-right" id="daterangepicker">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="create" class="btn btn-success">Hoàn tất</button>
                        <a href="{{ route('program.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-uppercase">Môn học</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="select2-lightblue">
                                <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn môn học" data-dropdown-css-class="select2-lightblue" style="width: 100%;" name="subjects[]" id="subject">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
            $('#daterangepicker').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#subject').select2();
        });
    </script>
@endsection
