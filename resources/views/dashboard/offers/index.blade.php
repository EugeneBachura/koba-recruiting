@php
    use App\Models\Recruiter;
@endphp

@extends('layouts.dashboard')

@section('title', 'Offers')
@section('h1', 'Offers')

@section('content')
<section class="section">
    @if (session('success')) 
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
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
            <div class="card-header d-flex justify-content-between align-items-center"><div>{{
                Recruiter::where('id', $offer['recruiter_id'])->first()->firm_name
                }}</div>
                <div>
                    <a href="{{ route('offers.show', $offer['id']) }}" class="btn btn-primary btn-sm" title="Show"><i class="bi bi-eye"></i></a>
                </div>
            </div>
            <div class="card-body">
            <h5 class="card-title">{{$offer['position']}}</h5>
            @if ($offer['description'])
                <p class="card-text">{{$offer['description']}}</p>
            @endif
            @if ($offer['level'])
                <p class="card-text">Level: {{$offer['level']}}</p>
            @endif
            @if ($offer['skills'])
                <p class="card-text">Skills: {{$offer['skills']}}</p>
            @endif
            </div>
            
            <div class="card-footer d-flex justify-content-end align-items-center">
                @if ($offer['duration'])
                    <div>Duration: {{$offer['duration']}}</div>
                @endif
            </div>
        </div>
    @endforeach
    <div>{!! $offers->appends(['sort' => 'created_at'])->links() !!}</div>
</section>
@endsection