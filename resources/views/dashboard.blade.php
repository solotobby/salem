{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.master')
@section('title', 'Dashboard')

@section('style')
<style>
:root {
  --star-size: 20px;
  /* --star-color: #fff; */
  --star-color: #B2BEB5;
  --star-background: #fc0;
}

.Stars {
  --percent: calc(var(--rating) / 5 * 100%);
  
  display: inline-block;
  font-size: var(--star-size);
  font-family: Times; // make sure ★ appears correctly
  line-height: 1;
  
  &::before {
    content: '★★★★★';
    letter-spacing: 3px;
    background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
}


</style>
@endsection

@section('content')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Advisers</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Advisers</li>
                </ol>
            </div>
        </div>

          <!-- start row -->
          <div class="row">

            <div class="col-12">
                @foreach ($advisers as $adviser)
                <a href="{{ url('adviser/'.$adviser->unique_id) }}">
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="assets/images/users/user-11.jpg" class="rounded-2 avatar-xxl" alt="image profile">

                                    <div class="overflow-hidden ms-4">
                                        <h4 class="m-0 text-dark fs-20">{{$adviser->name}}</h4>
                                        <p class="my-1 text-muted fs-16">{{$adviser->shout_out}}</p>
                                        <span class="fs-15"><i class="mdi mdi-message me-2 align-middle"></i>
                                            Specialties: 
                                            {{-- {{ $adviser }} --}}
                                            @if(!is_array($adviser['specs']))
                                                @foreach($adviser['specs'] as $specialty)
                                                <span>{{ $specialty['name'] }}, </span>
                                                
                                                @endforeach
                                            @else
                                                Null
                                            @endif
                                            {{-- <span>English <span class="badge bg-primary-subtle text-primary px-2 py-1 fs-13 fw-normal">native</span> , Spanish, Turkish </span> --}}
                                        </span>
                                        <br>
                                        <div class="Stars" style="--rating: {{$adviser->avg_rating}};" aria-label="Rating of this product is 2.3 out of 5.">
                                        {{-- <br> --}}
                                        {{-- <button type="button" class="btn btn-dark btn-lg">Book An Appointment</button> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                </a>
                @endforeach
               
                
                
            </div>

           
          </div>
        <!-- end row -->

        


         
        
    </div> <!-- container-fluid -->

</div> <!-- content -->

@endsection

