@php
    use App\Models\Offer;
    $offer = Offer::where('id', $response['offer_id'])->first()->only(['id', 'position']);
    use App\Models\Candidate;
    $candidate = Candidate::where('id', $response['candidate_id'])->first()->only(['user_id', 'first_name', 'last_name']);
    use App\Models\Recruiter;
    $recruiter = Recruiter::where('id', $response['recruiter_id'])->first()->only(['user_id', 'first_name', 'last_name', 'position']);
@endphp

@extends('layouts.dashboard')

@section('title', 'Response '.$offer['position'])
@section('h1', 'Response '.$offer['position'])

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
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                @if ($response['status'] == 'responded')
                    <span class="badge bg-warning text-dark">Not viewed</span>
                @endif
                @if ($response['status'] == 'viewed')
                    <span class="badge bg-success">Viewed</span>
                @endif
                @if ($response['status'] == 'denied')
                    <span class="badge bg-danger">Denied</span>
                @endif
                @if ($response['status'] == 'invited')
                    <span class="badge bg-primary">Invited</span>
                @endif
            </div>
            <div class="d-flex">
                @role('recruiter')
                <div class="mr-2">
                    <form action="{{ route('responses.update', $response['id']) }}" method="POST" id="denied" name="denied">
                        @csrf
                        @method('PUT')
                        <input type="disabled" name="status" value="denied" hidden>
                        <button class="btn btn-danger btn-sm" type="submit" form="denied"><i class="bi bi-person-x"></i></button>
                    </form>
                </div>
                <div>
                    <form action="{{ route('responses.update', $response['id']) }}" method="POST" id="invited" name="invited">
                        @csrf
                        @method('PUT')
                        <input type="disabled" name="status" value="invited" hidden>
                        <button class="btn btn-primary btn-sm" type="submit" form="invited"><i class="bi bi-person-check"></i></button>
                    </form>
                </div>
                @endrole
            </div>
        </div>
        <div class="card-body pb-0">
          <h5 class="card-title">{{ $offer['position'] }}</h5>
          <p>Offer: 
            <a href="{{ route('offers.show', $offer['id']) }}">{{ $offer['position'] }}</a>
          </p>
          <p>Candidate: 
            <a href="{{ route('profile.show', $candidate['user_id']) }}">{{ $candidate['first_name'] }} {{ $candidate['last_name'] }}</a>
          </p>
          <p>Rercuiter: 
            <a href="{{ route('profile.show', $recruiter['user_id']) }}">{{ $recruiter['first_name'] }} {{ $recruiter['last_name'] }}</a>
          </p>
        </div>
        <div class="card-footer">
            Time of response: {{$response['created_at']->format('d.m.Y H:i')}}
        </div>
    </div>
</section>
@endsection