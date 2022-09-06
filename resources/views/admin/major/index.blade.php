@extends('admin.layout.main')
@section('title', 'Chuyên ngành học')
@section('content')
    <div class="row form-group">
        <div class="col-md-3 offset-9 text-right">
{{--            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#file"><i class="fas fa-file-csv"></i>  Xuất/Nhập file</button>--}}
            <a class="btn btn-primary" href="{{ route('major.create') }}">Tạo mới</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <table id="datatable" class="table align-middle table-bordered">
                <thead>
                <tr class="bg-dark">
                    <th class="fs-5 border-0 text-white text-center">#</th>
                    <th class="fs-5 border-0 text-white">Tên</th>
                    <th class="fs-5 border-0 text-white text-center">Mã</th>
                    <th class="fs-5 border-0 text-white text-center">Ngày tạo</th>
                    <th class="fs-5 border-0 text-white text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $each)
                    @if($each->status == 1)
                        <tr class="clickable-row" onclick="window.location='{{ route('major.show', $each->id) }}'">
                            <td class="border-0 align-middle text-center">{{ $loop->index + 1 }}</td>
                            <td class="border-0 align-middle">{{ $each->name }}</td>
                            <td class="border-0 align-middle text-center">{{ $each->codeName }}</td>
                            <td class="border-0 align-middle text-center">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                            <td class="border-0 align-middle text-center">
                                <form action="{{ route('major.destroy', $each->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @else
                        <tr class="clickable-row table-active" onclick="window.location='{{ route('major.show', $each->id) }}'">
                            <td class="border-0 align-middle text-center">{{ $loop->index + 1 }}</td>
                            <td class="border-0 align-middle">{{ $each->name }}</td>
                            <td class="border-0 align-middle text-center">{{ $each->codeName }}</td>
                            <td class="border-0 align-middle text-center">{{ date_format($each->created_at, 'd/m/Y') }}</td>
                            <td class="border-0 align-middle text-center">
                                <form action="{{ route('major.restore', $each->id) }}" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-redo"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="row text-right">
                {{ $data->links() }}
            </div>
        </div>
    </div>

{{--    Modal xuất/nhập file--}}
    <div class="modal fade" id="file">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header dark-mode">
                    <h5 class="modal-title font-weight-bold">Xuất/Nhập file</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item active">
                            <a class="nav-link active" href="#importTab" aria-controls="importTab" role="tab" data-toggle="tab">Nhập file</a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#exportTab" aria-controls="exportTab" role="tab" data-toggle="tab">Xuất file</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="importTab">
                            <div class="row p-3">
                                <div class="col-md">
                                    <button type="button" class="btn btn-outline-primary" href="{{ asset('admin/major/export') }}"><i class="fas fa-file-alt"></i> Tải file mẫu (.xlsx)</button>
                                </div>
                            </div>
                            <div class="row">
                                <form action="{{ asset('admin/major/import') }}" class="dropzone" id="import">
                                    @csrf
                                    <div class="dz-message" data-dz-message>
                                        <span>Kéo file vào đây hoặc click để</span><br>
                                        <span class="btn text-green" href="{{ asset('admin/major/import') }}"><i class="fas fa-file-import"></i> Chọn file</span>
                                    </div>
                                </form>
                                <i class="small">*Lưu ý: chỉ chấp nhận định dạng Excel (.xls, .xlsx) khi nhập file</i>
                            </div>
                        </div>
                        <div class="tab-pane" id="exportTab">
                            <div class="row p-sm-3">
                                <button type="button" class="btn btn-outline-success" href="{{ asset('admin/major/export') }}"><i class="fas fa-file-export"></i> Xuất</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function(){
            Dropzone.options.import = {
                url: '{{ asset('admin/major/import') }}',
                acceptedFiles: '.xls, .xlsx',
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });
                }
            }
        });
    </script>
@endsection
