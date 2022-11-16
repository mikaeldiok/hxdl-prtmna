<div class="card frontend-tanker tanker-card position-relative" style="width: 200px;height: 35rem;">
  <div class="position-absolute mx-1" style="left:0;">
    <a class="btn btn-sm btn-blue hover-tool rounded-bottom" href="#"><i class="fa fa-exchange"></i></a>
  </div>
  <div class="position-absolute mx-1" style="right:0;">
    <a class="btn btn-sm btn-warning hover-tool rounded-bottom" href="#"><i class="fa fa-bookmark"></i></a>
  </div>
  <a href="#"><img class="card-img-top img-fluid" src="{{$tanker->photo ? asset($tanker->photo) : asset('img/default-avatar.jpg') }}" alt="Image placeholder" style="max-height:190px;min-height:190px;object-fit: cover;"></a>
  <div class="card-body">
    @if($tanker->checkBookedBy(auth()->user()->corporation->id ?? 0)
      <button class="btn btn-block btn-danger" id="choose-tanker-{{$tanker->id}}">Batal</button>
    @else
      <button class="btn btn-block btn-success" id="choose-tanker-{{$tanker->id}}">Pilih</button>
    @endif
    <a href="#">
      <h4 class="card-title pt-3" style="font-size: 22px">{{\Illuminate\Support\Str::limit($tanker->name, 17, $end = '...')}}</h4>
    </a>
      <h4 class="card-title" style="font-size: 19px">{{$tanker->major}} - {{$tanker->year_class}}</h4>
    <!-- detail -->

    @include('vehicle::frontend.tankers.tanker-card-detail')
    
    <!-- detail end -->
    <span class="donation-time mb-3 d-block">--</span>
    
  </div>
</div>

@push('after-scripts')
<script>
    $(document).ready(function(){
        $('#choose-tanker-{{$tanker->id}}').on('click', function(e) {
            $.ajax({
                type: "POST",
                url: '{{route("frontend.bookings.pickTanker")}}',
                data: {
                    "corporation_id" : "{{auth()->user()->id}}",
                    "tanker_id" : "{{$tanker->id}}",
                    "status" : "Picked",
                    "_method":"POST",
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                  if(response.isPicked){

                    console.log($(this));
                    $('#choose-tanker-{{$tanker->id}}').removeClass( 'btn-success');
                    $('#choose-tanker-{{$tanker->id}}').addClass( 'btn-danger');
                    $('#choose-tanker-{{$tanker->id}}').html( 'batal');

                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                    })

                    Toast.fire({
                    icon: 'success',
                    title: 'Siswa ditambahkan ke daftar anda'
                    })
                  }else{

                    $('#choose-tanker-{{$tanker->id}}').removeClass( 'btn-danger');
                    $('#choose-tanker-{{$tanker->id}}').addClass( 'btn-success');
                    $('#choose-tanker-{{$tanker->id}}').html( 'pilih');
                    
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                    })

                    Toast.fire({
                    icon: 'error',
                    title: response.message
                    })
                  }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    timer: 3000,
                    timerProgressBar: true,
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan! Silakan coba beberapa saat lagi.'
                    })
                }
            });
        });
    });
</script>
@endpush