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
