@php
    use App\Models\Recruiter;
@endphp

@extends('layouts.dashboard')

@section('title', 'Offers')
@section('h1', 'Offers')

@section('content')
<section class="section">
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @foreach ($offers as $offer)
        <div class="card">
            <div class="card-header">{{
                Recruiter::where('id', $offer['recruiter_id'])->first()->firm_name
                }}</div>
            <div class="card-body">
            <h5 class="card-title">{{$offer['position']}}</h5>
            <p>{{$offer['description']}}</p>
            @if ($offer['level'])
                <p>Level: {{$offer['level']}}</p>
            @endif
            @if ($offer['skills'])
                <p>Skills: {{$offer['skills']}}</p>
            @endif
            </div>
            <div class="card-footer text-end">
                Duration: {{$offer['duration']}}
            </div>
        </div>
    @endforeach
    <div>{!! $offers->appends(['sort' => 'created_at'])->links() !!}</div>
</section>
@endsection