@extends('layouts.app')

@section('content')
<h2>Edit Profile</h2>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div style="color: red; margin-bottom: 15px;">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('user.profile.update') }}">
    @csrf
    
    <label>Name:</label>
    <input type="text" name="name" value="{{ $user->name }}" required>
    
    <label>Email:</label>
    <input type="email" name="email" value="{{ $user->email }}" required>
    
    <button type="submit">Update Profile</button>
</form>

<div class="card" style="margin-top: 20px;">
    <h3>Account Information</h3>
    <p>Member since: {{ $user->created_at->format('d M Y') }}</p>
    <p>Role: {{ $user->roles->first()->name ?? 'user' }}</p>
</div>
@endsection