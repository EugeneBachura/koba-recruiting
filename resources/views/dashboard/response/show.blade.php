@php
    use App\Models\Offer;
@endphp

@extends('layouts.dashboard')

@section('title', 'Response')
@section('h1', 'Response')

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
            <div>
                {{-- <a href="{{ route('offers.show', $response['offer_id']) }}" class="btn btn-primary btn-sm" title="Show"><i class="bi bi-eye"></i></a> --}}
            </div>
        </div>
        <div class="card-body pb-0">
            @php
                $offer = Offer::where('id', $response['offer_id'])->first();
            @endphp
          <h5 class="card-title">{{ $offer->position }}</h5>
          <p></p>
        </div>
        <div class="card-footer">
            Time of response: {{$response['created_at']->format('d.m.Y H:i')}}
        </div>
    </div>
</section>
@endsection