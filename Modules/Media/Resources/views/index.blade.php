@extends('base::cmspanel.layout.dashboard')

@push('header')
{!! LouisMedia::renderHeader() !!}
@endpush


@section("content")
    {!! LouisMedia::renderContent() !!}
@endsection

@push('footer')
    {!! LouisMedia::renderFooter() !!}
@endpush