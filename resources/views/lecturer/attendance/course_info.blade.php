{{--
    Thông tin chung của khóa học
--}}

<span name="general-info" class="">
    @isset($curCourse)
        <h4>Phân công: <?php echo $curCourse->{'name'} ?? 'Chưa có'; ?></h4>
        <h4>Lớp: {{ $curClass->name ?? 'Chưa có'}}</h4>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <p>Số giờ dự kiến</p>

                        <h3><?php echo isset($curCourse) ? $curCourse->{'total_hours'} + 0 : 0; ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <p>Số giờ còn lại</p>

                        <h3><?php echo isset($curCourse) ?
                                $curCourse->{'total_hours'} - $curCourse->{'finished_hours'} + 0 : 0;
                            ?>
                        </h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <p>Số buổi đã dạy</p>

                        <h3><?php echo $curCourse->{'finished_lessons'} ?? '0'; ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
        </div>
    @endisset
</span>
