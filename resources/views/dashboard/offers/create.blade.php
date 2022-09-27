@extends('layouts.dashboard')

@section('title', 'Create New Offer')
@section('h1', 'New Offer')

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

          <!-- Create Form -->
          <form action="{{ route('offers.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="row mb-3">
                <label for="position" class="col-sm-2 col-form-label">Position</label>
                <div class="col-sm-10">
                  <input name="position" type="text" class="form-control" id="position" value="{{old('position')}}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="level" class="col-sm-2 col-form-label">Level</label>
                <div class="col-sm-10">
                  <input name="level" type="text" class="form-control" id="level" value="{{old('level')}}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control" id="description" style="height: 100px" required>{{old('description')}}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="skills" class="col-sm-2 col-form-label">Skills</label>
                <div class="col-sm-10">
                  <input name="skills" type="text" class="form-control" id="skills" value="{{old('skills')}}">
                </div>
            </div>

            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="gridRadios1" value="1" 
                        @if (old('active') === '1' || old('active') === null) checked="" @endif>
                        <label class="form-check-label" for="gridRadios1">
                        Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="active" id="gridRadios2" value="0" 
                        @if (old('active') === '0') checked="" @endif>
                        <label class="form-check-label" for="gridRadios2">
                          Inactive
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="row mb-3">
                <label for="duration" class="col-sm-2 col-form-label">Duration</label>
                <div class="col-sm-10">
                  <input name="duration" type="date" class="form-control" id="duration" value="{{old('duration')}}" required>
                </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </div>

          </form><!-- End Create Form -->

        </div>
      </div>
</section>
@endsection