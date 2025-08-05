@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-8 text-center">
    <div class="mb-6">
        <i class="fas fa-tachometer-alt text-6xl text-blue-500 mb-4"></i>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-600 text-lg">Anda berhasil masuk ke panel admin</p>
</div>
@endsection


