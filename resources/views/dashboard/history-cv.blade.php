@extends('layouts.dashboard')

@section('title', 'History CV')
@section('h1', 'History CV')

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
        <div class="card-body">
          <h5 class="card-title"></h5>

          @if ($user['cv_history'])
            @php
                $cv_history = json_decode($user['cv_history'], true);
            @endphp
            
            <!-- Table-->
            <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name File</th>
                    <th scope="col">Seze File</th>
                    <th scope="col">Upload Date</th>
                    <th scope="col">Download</th>
                </tr>
            </thead>
            <tbody>
            @php
                $k = 0;
            @endphp
            @foreach (array_reverse($cv_history) as $cv)
                <tr>
                    <th scope="row">{{++$k}}</th>
                    <td>{{$cv['name']}}</td>
                    <td>{{$cv['size']/1000}} KB</td>
                    <td>{{$cv['created_at']}}</td>
                    <td><a href="{{route('history-cv-download', $k)}}" class="btn btn-primary">Download</a></td>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
            <!-- End Table-->
          @endif

        </div>
      </div>
</section>
@endsection