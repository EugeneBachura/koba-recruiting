@extends('layouts.dashboard')

@section('title', 'My Offers')
@section('h1', 'My Offers')

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
            <div class="card-header d-flex justify-content-between">
                <div> 
                    @if ($offer['active'] == 0)
                        <span class="badge bg-warning text-dark">Inactive</span>
                    @elseif ($offer['active'] == 1)
                        <span class="badge bg-success">Active</span>
                    @endif
                </div>
                <div class="d-flex">
                    <a href="{{ route('offers.edit', $offer['id']) }}" class="btn btn-primary btn-sm mr-2" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('offers.destroy', $offer['id']) }}" method="POST">
                        @csrf
                        @method('DELETE') 
                        <button class="btn btn-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                   </form>
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
            </div>
            <div class="card-footer text-end">
                Duration: {{$offer['duration']}}
            </div>
        </div>
    @endforeach
    <div>{!! $offers->appends(['sort' => 'created_at'])->links() !!}</div>
</section>
@endsection