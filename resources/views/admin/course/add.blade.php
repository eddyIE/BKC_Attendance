@extends('admin.layout.main')
@section('title', 'THÊM KHÓA HỌC')
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khóa học</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('store_course') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên khóa học</label>
                        @error('courseName')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="courseName" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="credit_hours">Tổng số giờ</label>
                        @error('creditHours')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="credit_hours" name="creditHours" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- select -->
                            <div class="form-group">
                                <label>Lớp học</label>
                                <select class="form-control" name="class" id="inputClass"
                                    onchange="makeSubmenu(this.value)" size="1">
                                    <option value="" disabled selected>Chọn lớp</option>
                                    @foreach ($class as $each)
                                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <!-- select -->
                            <div class="form-group">
                                <label>Môn học</label>
                                <select class="form-control" name="subject" id="inputSubject" size="1">
                                    <option value="" disabled selected>Chọn môn học</option>
                                    {{-- @foreach ($subject as $each)
                                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- select -->
                            <div class="form-group">
                                <label>Giảng viên</label>
                                <select class="form-control" name="lecturer">
                                    @foreach ($lecturer as $each)
                                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <!-- select -->
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="form-control" name="type">
                                    <option value="0">Giảng viên chính</option>
                                    <option value="1">Giảng viên phụ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('course') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
    <div style="display: none;" id="courseCheck">
        {{ $checkCourse }}
    </div>
    <script>
        var data = JSON.parse(document.querySelector("#courseCheck").innerHTML);
        console.log(data);

        function makeSubmenu(value) {
            if (value.length == 0) {
                document.getElementById("inputSubject").innerHTML = "<option></option>";
            } else {
                var subjectOptions = "";
                for (subject in data[value]) {
                    subjectOptions += `<option value='${data[value][subject][1]}'>${data[value][subject][0]}</option>`;
                }
                document.getElementById("inputSubject").innerHTML = subjectOptions;
            }
        }

        function resetSelection() {
            document.getElementById("inputClass").selectedIndex = 0;
            document.getElementById("inputSubject").selectedIndex = 0;
        }
    </script>
@endsection
