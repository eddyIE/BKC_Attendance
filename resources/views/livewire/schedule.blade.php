<div>
    <form wire:submit.prevent="schedule">
        @csrf
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-uppercase">Phân công giảng viên</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            @foreach($lecturer as $index => $schedule)
                                @if($index == 0)
                                    <select wire:model="lecturer.0" class="form-control col-9" name="lecturer[]" id="lecturer">
                                        @foreach ($lecturers as $lecturer)
                                            <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-group"></div>
                                @else
                                    <div class="row form-group">
                                        <div class="col-9">
                                            <select wire:model="lecturer.{{ $index }}" class="form-control" name="lecturer[]" id="lecturer">
                                                @foreach ($lecturers as $lecturer)
                                                    <option value="{{ $lecturer->id }}">{{ $lecturer->full_name }} (dạy thay)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <button wire:click.prevent="removeLecturer({{ $index }})" class="btn text-danger"><i class="fa fa-minus-circle"></i></button>
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
                            <button wire:click.prevent="newLecturer" type="button" class="btn text-primary">
                                <i class="fa fa-sm fa-plus-circle"></i> Thêm giảng viên dạy thay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-danger">Phân công</button>
            </div>
        </div>
    </form>

    <script>
        window.addEventListener('swal',function(e){
            Swal.fire(e.detail);
        });
    </script>
</div>
