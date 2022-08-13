@extends('lecturer.layout.main')

@section('title', 'BKACAD - Quản lí phân công')


@section('content')
    {{--Bảng hiện thị các phân công--}}
    @include('lecturer.course.course_list')
@endsection

@section('script')
@endsection
