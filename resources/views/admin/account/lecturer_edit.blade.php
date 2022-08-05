@extends('layout')
@section('content')
    <form action="#" method="post">
        @csrf
        <div id="studentRecords">
            <div class="student-record">
                <table class="table table-striped align-middle table-bordered">
                    <tr>
                        <th td class="text-center fs-5 text-white bg-dark">Name</th>
                        <td><input class="form-control" type="text" name="name" value="{{ $edit[0]->name }}"></td>
                    </tr>
                    <tr>
                        <th td class="text-center fs-5 text-white bg-dark">Role</th>
                        <td><input class="form-control" type="text" name="name" value="{{ $edit[0]->title }}"></td>
                    </tr>
                    <tr>
                        <th td class="text-center fs-5 text-white bg-dark">Phone</th>
                        <td><input class="form-control" type="text" name="name" value="{{ $edit[0]->phone }}"></td>
                    </tr>
                    <tr>
                        <th td class="text-center fs-5 text-white bg-dark">Address</th>
                        <td><input class="form-control" type="text" name="name" value="{{ $edit[0]->address }}"></td>
                    </tr>
                    <tr>
                        <th td class="text-center fs-5 text-white bg-dark">Gender</th>
                        <td><input class="form-control" type="text" name="name" value="{{ $edit[0]->gender }}"></td>
                    </tr>
                    <tr>
                        <th td class="text-center fs-5" colspan="2">Finish</th>
                </table>
            </div>
        </div>
    </form>
@endsection
