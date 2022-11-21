@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<div class="site-section border-top bg-dark">
    <div class="container">
      
    </div>
  </div> <!-- .site-section -->


  <div class="site-section border-top mt-10">
    <div class="container">
      <div class="row">

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon text-warning"><span class="ion-ios-bulb"></span></div>
            <div class="media-body">
              <h3 class="heading">AMT</h3>
              <p>daftar pretrip amt</p>
              <p><a href="{{route('frontend.inspections.create-part-1')}}" class="link-underline">Learn More</a></p>
            </div>
          </div>     
        </div>

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon text-warning"><span class="ion-ios-cash"></span></div>
            <div class="media-body">
              <h3 class="heading">Pengawas</h3>
              <h5 class="text-black">user: pengawas@example.com</h5>
              <h5>pass: secret</h5>
              <p><a href="{{route('login')}}" class="link-underline">Login here</a></p>
            </div>
          </div>  
        </div>

        <div class="col-md-4">
          <div class="media block-6">
            <div class="icon text-warning"><span class="ion-ios-contacts"></span></div>
            <div class="media-body text-danger">
              <h3 class="heading">HSSE</h3>
              <h5 class="text-black">user: hsse@example.com</h5>
              <h5>pass: secret</h5>
              <p><a href="{{route('login')}}" class="link-underline">Login here</a></p>
            </div>
          </div> 
        </div>

      </div>
    </div>
  </div> <!-- .site-section -->


@endsection

@push ('after-styles')
@endpush

@push ('after-scripts')


@endpush
