@extends('admin.layout.main')
@section('title', $course->name)
@section('content')
    <div class="col-md-6">
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khóa học</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên khóa học</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $course->course }}">
                </div>
                <div class="form-group">
                    <label for="total_hours">Thời lượng môn</label>
                    <input type="text" class="form-control" id="total_hours" name="total_hours" value="{{ $course->credit_hours }}">
                </div>


                {{--NẠI NÀ LIVEWIRE :DDD--}}
                <livewire:show-subject :classId="$course->class_id" :subjectId="$course->subject_id" :schedule="$lecturers"/>

                <div class="row">
                    <div class="col-md-6">
                        <label for="scheduled_day">Lịch dạy</label>
                        <div class="select2-lightblue">
                            <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn những buổi dạy trong tuần" data-dropdown-css-class="select2-lightblue" style="width: 100%;" name="scheduled_day[]" id="scheduled_day">
                                <option value="1">Thứ Hai</option>
                                <option value="2">Thứ Ba</option>
                                <option value="3">Thứ Tư</option>
                                <option value="4">Thứ Năm</option>
                                <option value="5">Thứ Sáu</option>
                                <option value="6">Thứ Bảy</option>
                                <option value="0">Chủ Nhật</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Giờ dạy</label>
                        <div class="row">
                            <div class="input-group date col-md-6" id="start" data-target-input="nearest">
                                <input type="text" name="start" class="form-control text-center" placeholder="Bắt đầu" data-target="#start" data-toggle="datetimepicker"/>
                            </div>
                            <div class="input-group date col-md-6" id="end" data-target-input="nearest">
                                <input type="text" name="end" class="form-control text-center" placeholder="Kết thúc" data-target="#end" data-toggle="datetimepicker"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <p>Ngày tạo khóa học: {{ $course->created_at }}</p>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" id="update" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('course.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#scheduled_day').select2();

            $('#start, #end').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
                stepping: 15,
            });
        });
    </script>
@endsection
