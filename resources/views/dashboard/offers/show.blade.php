@php
use App\Models\Recruiter;
$recruiter = Recruiter::where('id', $offer['recruiter_id'])->first();
@endphp

@extends('layouts.dashboard')

@section('title', 'Offer '.$offer->position)
@section('h1', 'Offer '.$offer->position)

@section('content')
<section class="section row">
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

    @role('candidate')
    <div class="col-xl-3">
        <div class="card">
            <div class="d-flex justify-content-center align-items-center p-3" style="flex-wrap: wrap;">
                <div class="pr-3">
                    <a href="{{ route('profile.show', $recruiter->user_id) }}">
                        @if ($recruiter->photo)
                        <div class="avatar avatar-medium rounded-circle" style="background-image:url('{{Storage::url($user['photo'])}}');" alt="Avatar"></div>
                        @else
                        <div class="avatar avatar-medium rounded-circle" style="background-image:url('{{Storage::url('public/avatars/_ruser.png')}}');" alt="Avatar"></div>
                        @endif
                    </a>
                </div>
                <div class="">
                    <div class="card-body pb-0 text-center">
                        <a href="{{ route('profile.show', $recruiter->user_id) }}">
                            <h5 class="card-title pb-1">
                                @if ($recruiter->first_name && $recruiter->last_name)
                                {{ $recruiter->first_name }} {{ $recruiter->last_name }}
                                @if ($recruiter->position)
                                - {{ $recruiter->position }}
                                @endif
                                @endif
                            </h5>
                        </a>
                        @if ($recruiter->user_email)
                        <h6>Email: <a href="mailto:{{ $recruiter->user_email }}">{{ $recruiter->user_email }}</a></h6>
                        @endif
                        @if ($recruiter->telephone)
                        <h6>Phone: <a href="tel:{{ $recruiter->telephone }}">{{ $recruiter->telephone }}</a></h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole

    @role('candidate')
        <div class="col-xl-9">
    @endrole
    @role('recruiter')
        <div class="col-xl-12">
    @endrole
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>{{ $recruiter->firm_name }}</div>
                <div class="d-flex">
                    <a href="{{ route('offers.index') }}" class="btn btn-danger btn-sm ml-2" title="Return"><i class="bi bi-x-lg"></i></a>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{$offer['position']}}</h5>
                <p>{{$offer['description']}}</p>
                @if ($offer['level'])
                <p>Level: {{$offer['level']}}</p>
                @endif
                @if ($offer['skills'])
                <p>Skills: {{$offer['skills']}}</p>
                @endif

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div>
                        @role('candidate')
                        @if ($offer->active)
                        <form action="{{ route('responses.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" value="{{$offer['id']}}" name="offer" hidden>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle me-1"></i> Apply</button>
                        </form>
                        @else
                        {{-- Offer is not active --}}
                        <button class="btn btn-primary disabled" disabled type="btn">Offer inactive</button>
                        @endif
                        @endrole
                    </div>
                    <div>Duration: {{$offer['duration']}}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection