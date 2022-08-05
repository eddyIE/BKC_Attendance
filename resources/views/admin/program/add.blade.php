@extends('admin.layout.main')
@section('title', 'Thêm niên khóa ')
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
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="major_id">Chuyên ngành</label>
                            @error('major_id')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <select class="form-control" name="major_id" id="major_id" size="1">
                                <option value="" selected disabled hidden>Chọn chuyên ngành</option>
                                @foreach ($major as $each)
                                    <option value="{{ $each->id }}">{{ $each->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="session">Niên khóa</label>
                            @error('session')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <input type="text" class="form-control" id="session" name="session" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="start">Năm học</label>
                            @error('date_range')
                            <div class="danger text-red" style="float:right">{{ $message }}</div>
                            @enderror
                            <div class="input-group">
                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
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
                                <select class="form-control" multiple="multiple" data-placeholder="Vui lòng chọn môn học" data-dropdown-css-class="select2-lightblue" style="width: 100%;" name="subject" id="subject">
                                    <option>ITF</option>
                                    <option>EN1</option>
                                    <option>EN2</option>
                                    <option>EN3</option>
                                    <option>ADV</option>
                                    <option>DB</option>
                                    <option>SDLC</option>
                                    <option>NET</option>
                                    <option>SEC</option>
                                    <option>WEB</option>
                                    <option>MAC</option>
                                    <option>AI</option>
                                    <option>PRJ</option>
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
        $(function() {
            $('#daterangepicker').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#subject').select2();

            {{--$('#create').click(function (){--}}
            {{--    $.ajax({--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        url: '{{ route('program.store') }}',--}}
            {{--        type: 'POST',--}}
            {{--        dataType: 'text',--}}
            {{--        data: {--}}
            {{--            name: $('#name').val(),--}}
            {{--            major_id: $('#major_id').val(),--}}
            {{--            session: $('#session').val(),--}}
            {{--            date_range: $('#daterangepicker').val(),--}}
            {{--            subject: $('#subject').val(),--}}
            {{--        },--}}
            {{--        success: function (result){--}}
            {{--            location.reload();--}}
            {{--        },--}}
            {{--    });--}}
            {{--});--}}
        });
    </script>
@endsection
