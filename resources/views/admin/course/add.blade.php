@extends('admin.layout.main')
@section('title', 'Thêm lớp môn học')
@section('content')
    <div class="row">
        <form action="{{ route('course.store') }}" method="post" class="col-md-6">
            @csrf
            <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold text-uppercase">Thông tin lớp môn học</h3>
                </div>

                <div class="card-body">
                    <div class="row form-group">
                        <div class="col-md-9">
                            <label for="name">Tên lớp môn học</label>
                            @error('name')
                            <div class="danger text-red" style="float:right">*</div>
                            @enderror
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Tên">
                        </div>
                        <div class="col-md-3">
                            <label for="total_hours">Thời lượng môn</label>
                            @error('total_hours')
                            <div class="danger text-red" style="float:right">*</div>
                            @enderror
                            <input type="text" class="form-control" id="total_hours" name="total_hours" autocomplete="off" placeholder="Giờ">
                        </div>
                    </div>
                    <livewire:show-subject/>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="scheduled_day">Lịch dạy</label>
                            @error('total_hours')
                            <div class="danger text-red" style="float:right">*</div>
                            @enderror
                            <div class="select2-lightblue">
                                <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn những buổi dạy trong tuần" data-dropdown-css-class="select2-lightblue" style="width: 100%;" name="scheduled_day[]" id="scheduled_day">
                                    @foreach($week_days as $index => $day)
                                        <option value="{{ $index }}">{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Giờ dạy</label>
                            @if($errors->has('start') || $errors->has('end'))
                                <div class="danger text-red" style="float:right">*</div>
                            @endif
                            <div class="row">
                                <div class="input-group date col-md-6" id="start" data-target-input="nearest">
                                    <input type="text" name="start" class="form-control text-center datetimepicker-input" placeholder="Bắt đầu" data-target="#start" data-toggle="datetimepicker" autocomplete="off"/>
                                </div>
                                <div class="input-group date col-md-6" id="end" data-target-input="nearest">
                                    <input type="text" name="end" class="form-control text-center datetimepicker-input" placeholder="Kết thúc" data-target="#end" data-toggle="datetimepicker" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Hoàn tất">
                    <a href="{{ route('course.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            function validateTime(){

            };
            $('#scheduled_day').select2();

            $('#start, #end').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false,
                stepping: 60,
            });
        });
    </script>
@endsection
