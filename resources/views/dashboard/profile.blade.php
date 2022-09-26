@extends('layouts.dashboard')

@section('title', 'Edit Profile')
@section('h1', 'Profile')

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
            @if ($user['photo'])
                <div class="avatar rounded-circle" style="background-image:url('{{Storage::url($user['photo'])}}');" alt="Profile"></div>
            @else
                @role('candidate')
                    <div class="avatar rounded-circle" style="background-image:url('{{Storage::url('public/avatars/_cuser.png')}}');" alt="Profile"></div>
                @endrole
                @role('recruiter')
                    <div class="avatar rounded-circle" style="background-image:url('{{Storage::url('public/avatars/_ruser.png')}}');" alt="Profile"></div>
                @endrole
            @endif
            <h2 class="d-flex align-items-center text-center">{{$user['first_name']}} {{$user['last_name']}}</h2>
            <h3 class="disabled">{{$user['user_email']}}</h3>
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

              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Edit Profile</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-email" aria-selected="false" role="tab" tabindex="-1">Change Email</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" role="tab" tabindex="-1">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                @role('candidate')
                    @if ($user['about'])
                        <h5 class="card-title">About</h5>
                        <p class="small fst-italic">{{$user['about']}}</p>
                    @endif
                @endrole

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{$user['first_name']}} {{$user['last_name']}}</div>
                </div>

                @role('candidate')
                @if ($user['date_of_birth'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Birthday</div>
                    <div class="col-lg-9 col-md-8">{{preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3/$2/$1", $user['date_of_birth'])}}</div>
                  </div>
                @endif
                @endrole

                @role('candidate')
                @if ($user['interests'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Interests</div>
                    <div class="col-lg-9 col-md-8">{{$user['interests']}}</div>
                  </div>
                @endif
                @endrole
                
                @role('candidate')
                @if ($user['education'] )
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Education</div>
                    <div class="col-lg-9 col-md-8">{{$user['education']}}</div>
                  </div>
                @endif
                @endrole

                @role('candidate')
                @if ($user['skills'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Skills</div>
                    <div class="col-lg-9 col-md-8">{{$user['skills']}}</div>
                  </div>
                @endif
                @endrole

                @role('recruiter')
                @if ($user['firm_name'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Firm Name</div>
                    <div class="col-lg-9 col-md-8">{{$user['firm_name']}}</div>
                  </div>
                @endif
                @endrole

                @role('recruiter')
                @if ($user['position'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Position</div>
                    <div class="col-lg-9 col-md-8">{{$user['position']}}</div>
                  </div>
                @endif
                @endrole

                @if ($user['telephone'])
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8">{{$user['telephone']}}</div>
                  </div>
                @endif

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{$user['user_email']}}</div>
                </div>

                @role('candidate')
                <div class="row mb-0">
                    <div><a type="button" class="btn btn-outline-primary" href="{{route('download-cv', $user['id'])}}"><i class="bi bi-download me-1"></i> Download CV</a></div>
                </div>
                @endrole

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">
                <!-- Profile Edit Form for Candidate -->
                <form action="{{ route('profile.update', $user['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="row mb-3">
                    <label for="photo" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                        @if ($user['photo'])
                            <img src="{{Storage::url($user['photo'])}}" alt="Profile"> 
                        @endif
                      <div class="pt-2">
                        <input type="file" class="form-control" name="photo" id="photo">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="first_name" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="first_name" type="text" class="form-control" id="first_name" value="{{$user['first_name']}}" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="last_name" type="text" class="form-control" id="last_name" value="{{$user['last_name']}}" required>
                    </div>
                  </div>

                  @role('candidate')
                  <div class="row mb-3">
                    <label for="date_of_birth" class="col-md-4 col-lg-3 col-form-label">Birthday</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="date_of_birth" type="text" class="form-control" id="date_of_birth" value="{{preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3$2$1", $user['date_of_birth'])}}">
                    </div>
                  </div>
                  @endrole

                  @role('candidate')
                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="about" class="form-control" id="about" style="height: 100px">{{$user['about']}}</textarea>
                    </div>
                  </div>
                    @endrole

                    @role('candidate')
                  <div class="row mb-3">
                    <label for="interests" class="col-md-4 col-lg-3 col-form-label">Interests</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="interests" type="text" class="form-control" id="interests" value="{{$user['interests']}}">
                    </div>
                  </div>
                    @endrole

                    @role('candidate')
                  <div class="row mb-3">
                    <label for="education" class="col-md-4 col-lg-3 col-form-label">Education</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="education" type="text" class="form-control" id="education" value="{{$user['education']}}">
                    </div>
                  </div>
                    @endrole

                    @role('candidate')
                  <div class="row mb-3">
                    <label for="skills" class="col-md-4 col-lg-3 col-form-label">Skills</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="skills" type="text" class="form-control" id="skills" value="{{$user['skills']}}">
                    </div>
                  </div>
                    @endrole

                    @role('recruiter')
                    <div class="row mb-3">
                        <label for="firm_name" class="col-md-4 col-lg-3 col-form-label">Firm Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="firm_name" type="text" class="form-control" id="firm_name" value="{{$user['firm_name']}}">
                        </div>
                    </div>
                    @endrole

                    @role('recruiter')
                    <div class="row mb-3">
                        <label for="position" class="col-md-4 col-lg-3 col-form-label">Position</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="position" type="text" class="form-control" id="position" value="{{$user['position']}}">
                        </div>
                    </div>
                    @endrole

                  <div class="row mb-3">
                    <label for="telephone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="telephone" type="text" class="form-control" id="telephone" value="{{$user['telephone']}}">
                    </div>
                  </div>

                  @role('candidate')
                  <div class="row mb-3">
                    <label for="cv" class="col-md-4 col-lg-3 col-form-label">CV File</label>
                    <div class="col-md-8 col-lg-9">
                        @if ($user['cv'])
                            <a type="button" class="btn btn-link" href="{{route('download-cv', $user['id'])}}"><i class="bi bi-download me-1"></i> Download</a>
                        @endif
                      <div class="pt-2">
                        <input type="file" class="form-control" name="cv" id="cv">
                      </div>
                    </div>
                  </div>
                    @endrole

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form for Candidate -->
              </div>

              <div class="tab-pane fade pt-3" id="profile-change-email" role="tabpanel">
                <!-- Change Email Form -->
                <form action="{{ route('email-update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-lg-3 col-form-label">New Email</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="email" type="email" class="form-control" id="email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="re-email" class="col-md-4 col-lg-3 col-form-label">Re-enter New Email</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="re-email" type="email" class="form-control" id="re-email">
                        </div>
                    </div>

                    <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Email</button>
                    </div>
                </form><!-- End Change Email Form -->
              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                <!-- Change Password Form -->
                <form action="{{ route('password-update') }}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_password" type="password" class="form-control" id="new_password">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="confirmed" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="confirmed" type="password" class="form-control" id="confirmed">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script>
    $(function(){
        $("#date_of_birth").mask("99/99/9999", {placeholder: "DD/MM/YYYY" });
        $("#telephone").mask("999-999-999");
    });
  </script>
@endsection