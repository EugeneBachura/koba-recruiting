@extends('layouts.dashboard')

@section('title', 'Edit Offer')
@section('h1', 'Edit Offer')

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
    @if (session('success')) 
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="card">
        <div class="card-body">
          <h5 class="card-title"></h5>

          <!-- Edit Form -->
          <form action="{{ route('offers.update', $offer['id']) }}" method="POST" id="update">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label for="position" class="col-sm-2 col-form-label">Position</label>
                <div class="col-sm-10">
                  <input name="position" type="text" class="form-control" id="position" value="@php
                        if (old('position')) {
                            echo old('position');
                        } else {
                            echo $offer->position;
                        }
                    @endphp" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="level" class="col-sm-2 col-form-label">Level</label>
                <div class="col-sm-10">
                  <input name="level" type="text" class="form-control" id="level" value="@php
                  if (old('level')) {
                      echo old('level');
                  } else {
                      echo $offer->level;
                  }
              @endphp">
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control" id="description" style="height: 100px" required>@php
                        if (old('description')) {
                            echo old('description');
                        } else {
                            echo $offer->description;
                        }
                    @endphp</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="skills" class="col-sm-2 col-form-label">Skills</label>
                <div class="col-sm-10">
                  <input name="skills" type="text" class="form-control" id="skills" value="@php
                  if (old('skills')) {
                      echo old('skills');
                  } else {
                      echo $offer->skills;
                  }
              @endphp">
                </div>
            </div>

            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="gridRadios1" value="1" @php
                            if (old('active') === '1' || $offer->active === 1) {
                                echo 'checked=""';
                            }
                        @endphp>
                        <label class="form-check-label" for="gridRadios1">
                        Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="gridRadios2" value="0" @php
                            if (old('active') === '0' || $offer->active === 0) {
                                echo 'checked=""';
                            }
                        @endphp>
                        <label class="form-check-label" for="gridRadios2">
                          Inactive
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="row mb-3">
                <label for="duration" class="col-sm-2 col-form-label">Duration</label>
                <div class="col-sm-10">
                  <input name="duration" type="date" class="form-control" id="duration" value="@php
                  if (old('duration')) {
                      echo old('duration');
                  } else {
                      echo $offer->duration;
                  }
              @endphp" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" form="update">Save</button>
                </div>
            </div>

          </form><!-- End Edit Form -->

        </div>
      </div>
</section>
@endsection