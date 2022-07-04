{{--
    Thông tin chung của khóa học
--}}

<span name="general-info" class="">
    @isset($curCourse)
        <h4>Lớp: <?php echo $curCourse->{'class_id'} ?? 'Chưa có'; ?></h4>
        <h4>Phân công: <?php echo $curCourse->{'name'} ?? 'Chưa có'; ?></h4>
        <h4>Tổng số giờ: <?php echo isset($curCourse) ? $curCourse->{'total_hours'} + 0 : 0; ?></h4>
        <h4>
            Số giờ còn lại:
            <?php //echo isset($curCourse) ?
                //$curCourse->{'total_hours'} - $curCourse->{'finished_hour'} + 0 : 0;
            ?>
        </h4>
        <h4>Số buổi đã dạy:
            <?php //echo $curCourse->{'finished_lesson'} ?? '0'; ?>
        </h4>
    @endisset
</span>
