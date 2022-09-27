@extends('layouts.dashboard')

@section('title', 'Profile '.$profile['first_name'].' '.$profile['last_name'])
@section('h1', 'Profile '.$profile['first_name'].' '.$profile['last_name'])

@section('content')
<section class="section profile">
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
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 pb-4 d-flex flex-column align-items-center">
            @if ($profile['photo'])
                <div class="avatar rounded-circle" style="background-image:url('{{Storage::url($profile['photo'])}}');" alt="Profile"></div>
            @else
                @if ($role == 'candidate')
                    <div class="avatar rounded-circle" style="background-image:url('{{Storage::url('public/avatars/_cuser.png')}}');" alt="Profile"></div>
                @endif
            @if ($role == 'recruiter')
                    <div class="avatar rounded-circle" style="background-image:url('{{Storage::url('public/avatars/_ruser.png')}}');" alt="Profile"></div>
                @endif
            @endif
            <h2 class="d-flex align-items-center text-center">{{$profile['first_name']}} {{$profile['last_name']}}</h2>
            <h3 class="disabled">{{$profile['user_email']}}</h3>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

              <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">Overview</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                @if ($role == 'candidate')
                    @if ($profile['about'])
                        <h5 class="card-title">About</h5>
                        <p class="small fst-italic">{{$profile['about']}}</p>
                    @endif
                @endif

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{$profile['first_name']}} {{$profile['last_name']}}</div>
                </div>

                @if ($role == 'candidate')
                @if ($profile['date_of_birth'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Birthday</div>
                    <div class="col-lg-9 col-md-8">{{preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3/$2/$1", $profile['date_of_birth'])}}</div>
                  </div>
                @endif
                @endif

                @if ($role == 'candidate')
                @if ($profile['interests'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Interests</div>
                    <div class="col-lg-9 col-md-8">{{$profile['interests']}}</div>
                  </div>
                @endif
                @endif
                
                @if ($role == 'candidate')
                @if ($profile['education'] )
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Education</div>
                    <div class="col-lg-9 col-md-8">{{$profile['education']}}</div>
                  </div>
                @endif
                @endif

                @if ($role == 'candidate')
                @if ($profile['skills'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Skills</div>
                    <div class="col-lg-9 col-md-8">{{$profile['skills']}}</div>
                  </div>
                @endif
                @endif

                @if ($role == 'recruiter')
                @if ($profile['firm_name'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Firm Name</div>
                    <div class="col-lg-9 col-md-8">{{$profile['firm_name']}}</div>
                  </div>
                @endif
                @endif

                @if ($role == 'recruiter')
                @if ($profile['position'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Position</div>
                    <div class="col-lg-9 col-md-8">{{$profile['position']}}</div>
                  </div>
                @endif
                @endif

                @if ($profile['telephone'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{$profile['telephone']}}</div>
                  </div>
                @endif

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{$profile['user_email']}}</div>
                </div>

                @if ($role == 'candidate')
                @if ($profile['cv']) 
                    <div class="row mb-0">
                        <div><a type="button" class="btn btn-outline-primary" href="{{route('download-cv', $profile['id'])}}"><i class="bi bi-download me-1"></i> Download CV</a></div>
                    </div>
                @endif
                @endif

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection