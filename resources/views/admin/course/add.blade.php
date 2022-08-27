@extends('admin.layout.main')
@section('title', 'Thêm khóa học')
@section('content')
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-gray">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Thông tin khóa học</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('course.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tên khóa học</label>
                        @error('name')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="total_hours">Thời lượng môn</label>
                        @error('total_hours')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" id="total_hours" name="total_hours" autocomplete="off">
                    </div>

                    {{--LIVEWIRE NIÈ :DDD--}}
                    <livewire:show-subject/>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="scheduled_day">Lịch dạy</label>
                            <div class="select2-lightblue">
                                <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn những buổi dạy trong tuần" data-dropdown-css-class="select2-lightblue" style="width: 100%;" name="scheduled_day[]" id="scheduled_day">
                                    <option value="Monday">Thứ Hai</option>
                                    <option value="Tuesday">Thứ Ba</option>
                                    <option value="Wednesday">Thứ Tư</option>
                                    <option value="Thursday">Thứ Năm</option>
                                    <option value="Friday">Thứ Sáu</option>
                                    <option value="Saturday">Thứ Bảy</option>
                                    <option value="Sunday">Chủ Nhật</option>
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

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('course.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
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
