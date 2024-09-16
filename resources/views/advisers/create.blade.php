@extends('layouts.master')
@section('title', 'Setup Adviser Information')

@section('content')

<div class="content">
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Adviser</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                    <li class="breadcrumb-item active">Setup</li>
                </ol>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Example</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('adviser.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Display Name</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter name" value="{{ auth()->user()->name }}" required>
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your
                                    email with anyone else.
                                </small> --}}
                            </div>
                           
                            <div class=" mb-3">
                                <label for="floatingTextarea" class="form-label">Brief Description</label>
                                <textarea class="form-control" name="shout_out" placeholder="A brief description of yourself" id="floatingTextarea" required></textarea>
                            </div>

                            <div class=" mb-3">
                                <label for="floatingTextarea" class="form-label">An Extensive description of yourself</label>
                                <textarea class="form-control"  name="description" placeholder="Write everything about you" id="floatingTextarea" required></textarea>
                            </div>
                            
                            <div class=" mb-3">
                                <label for="floatingTextarea" class="form-label">Choose Specialty</label>
                                <div class="col-sm-10 d-flex gap-2">
                                    @foreach ($specialties as $spec)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="specialties[]" value="{{ $spec->id }}" id="gridCheck{{ $spec->id }}">
                                            <label class="form-check-label" for="gridCheck{{ $spec->id }}">
                                               {{$spec->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <h3>Pricing</h3>
                            
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">15 min</label>
                                <input type="number" name="_15_min" class="form-control" id="exampleInputPassword1" placeholder="Enter amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">30 min</label>
                                <input type="number" class="form-control" name="_30_min" id="exampleInputPassword1" placeholder="Enter amount" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">1 hour</label>
                                <input type="number" class="form-control" name="_1_hour" id="exampleInputPassword1" placeholder="Enter amount" required>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">2 hours</label>
                                <input type="number" class="form-control" name="_2_hours" id="exampleInputPassword1" placeholder="Enter amount" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection