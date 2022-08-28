<div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="class">Lớp học</label>
                @error('class')
                <div class="danger text-red" style="float:right">{{ $message }}</div>
                @enderror
                <select wire:model="classId" name="class" id="class" class="form-control" data-placeholder="Chọn lớp">
                    <option value="">Chọn lớp</option>
                    @foreach ($classes as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="subject">Môn học</label>
                @error('subject')
                <div class="danger text-red" style="float:right">{{ $message }}</div>
                @enderror
                <select wire:model="subjectId" class="form-control" name="subject" id="subject" data-placeholder="Chọn môn">
                    <option value="">Chọn môn</option>
                    @foreach ($subjects as $each)
                        <option value="{{ $each->id }}">{{ $each->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="form-group">
                @foreach($schedule as $index => $schedule)
                    @if($index == 0)
                        <label for="lecturer[]">Giảng viên</label>
                        <select wire:model="lecturer.{{ $index }}" class="form-control col-6" name="lecturer[]" id="lecturer">
                            <option value="">Giảng viên chính</option>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group"></div>
                    @else
                        <div class="row">
                            <div class="form-group col-6">
                                <select wire:model="lecturer.{{ $index }}" class="form-control" name="lecturer[]" id="lecturer">
                                    <option value="">Giảng viên phụ</option>
                                    @foreach ($lecturers as $lecturer)
                                        <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-1">
                                <button type="button" class="btn text-danger"><i class="fa fa-minus-circle"></i></button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <button wire:click="newLecturer" type="button" class="btn text-primary">
                    <i class="fa fa-sm fa-plus-circle"></i> Thêm giảng viên
                </button>
            </div>
        </div>
    </div>

</div>
