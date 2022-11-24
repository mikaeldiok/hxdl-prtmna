@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

  <div class="site-section border-top">
    <div class="container">
      <div class="row">

        <div class="col-md-6 col-sm-6 mt-2">
          <div class="media block-6">
            <div class="icon text-warning"><span class="ion-ios-bulb"></span></div>
            <div class="media-body">
              <h3 class="heading">AMT</h3>
              <p>Daftar OPTRIM AMT</p>
              <p><a href="{{route('frontend.inspections.create-part-1')}}" class="link-underline">Create Inspection</a></p>
            </div>
          </div>     
        </div>

        <div class="col-md-6 col-sm-6 mt-2">
          <div class="media block-6">
          <div class="icon text-warning"><span class="ion-ios-bulb"></span></div>
            <div class="media-body">
              <h3 class="heading">Pengawas | HSSE</h3>
              <p>Login untuk pengawas dan HSSE</p>
              <p><a href="{{route('backend.dashboard')}}" class="link-underline">Login here</a></p>
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
