@extends('layouts.panel')

@section('page-title', 'Dashboard Admin')
@section('page-description', 'Ringkasan koleksi, stok, dan aktivitas perpustakaan.')

@section('content')
    @include('admin.dashboard_content_clean')
@endsection
