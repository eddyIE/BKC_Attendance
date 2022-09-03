{{--Thông tin dạng bảng về lớp môn học--}}
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Chuyên cần lớp môn học</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="datatable" class="table align-middle table-bordered">
                            <thead>
                            <tr class="bg-dark">
                                <th class="fs-5 text-white text-center border-0">STT</th>
                                <th class="fs-5 text-white text-center border-0">Lớp</th>
                                <th class="fs-5 text-white text-center border-0">Môn</th>
                                <th class="fs-5 text-white text-center border-0">Thời lượng môn</th>
                                <th class="fs-5 text-white text-center border-0">Thời lượng còn lại</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($courses as $course)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>
                                        <a href="{{asset('/admin/statistic/'.$course->id)}}">
                                            {{$course->name}}
                                        </a>
                                    </td>
                                    <td>{{$course->program_info->subject->name}}</td>
                                    <td>{{ (float) $course->total_hours . ' giờ' }}</td>
                                    <td>
                                        {{ (float) $course->total_hours - (float) $course->finished_hours . ' giờ' }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 justify-content-center">
                    <div class="col-md-11">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-3">
                        <h5>Giảng viên đã dạy lớp môn học</h5>
                        <table id="datatable" class="table align-middle table-bordered">
                            <thead>
                            <tr class="bg-info">
                                <th class="fs-5 text-white text-center border-0">STT</th>
                                <th class="fs-5 text-white text-center border-0">Giảng viên</th>
                                <th class="fs-5 text-white text-center border-0">Thời lượng dạy</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($taughtTimeInCourse as $each)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>
                                        {{$each->full_name}}
                                    </td>
                                    <td>{{$each->timeKeeping . ' giờ' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-8 mt-3">
                        <h5 class="text-center">Biểu đồ xét chuyên cần lớp môn học {{$chosenCourseName}}</h5>
                        <canvas id="donutChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
