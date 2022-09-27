@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('h1', '')

@section('content')
<div class="section">
    <div class="card">
        <div class="card-body">
          <h4 class="card-title">Welcome {{$user['first_name']}}!</h4>
          <p class="card-text">Today @php
            echo date('l, F jS, Y');
          @endphp</p>
        </div>
    </div>
</div>
@endsection