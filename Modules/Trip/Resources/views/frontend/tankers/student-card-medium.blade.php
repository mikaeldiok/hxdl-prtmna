<div class="card frontend-inspection inspection-card position-relative" style="width: 200px;height: 35rem;">
  <div class="position-absolute mx-1" style="left:0;">
    <a class="btn btn-sm btn-blue hover-tool rounded-bottom" href="#"><i class="fa fa-exchange"></i></a>
  </div>
  <div class="position-absolute mx-1" style="right:0;">
    <a class="btn btn-sm btn-warning hover-tool rounded-bottom" href="#"><i class="fa fa-bookmark"></i></a>
  </div>
  <a href="#"><img class="card-img-top img-fluid" src="{{$inspection->photo ? asset($inspection->photo) : asset('img/default-avatar.jpg') }}" alt="Image placeholder" style="max-height:190px;min-height:190px;object-fit: cover;"></a>
  <div class="card-body">
    @if($inspection->checkBookedBy(auth()->user()->corporation->id ?? 0)
      <button class="btn btn-block btn-danger" id="choose-inspection-{{$inspection->id}}">Batal</button>
    @else
      <button class="btn btn-block btn-success" id="choose-inspection-{{$inspection->id}}">Pilih</button>
    @endif
    <a href="#">
      <h4 class="card-title pt-3" style="font-size: 22px">{{\Illuminate\Support\Str::limit($inspection->name, 17, $end = '...')}}</h4>
    </a>
      <h4 class="card-title" style="font-size: 19px">{{$inspection->major}} - {{$inspection->year_class}}</h4>
    <!-- detail -->

    @include('trip::frontend.inspections.inspection-card-detail')
    
    <!-- detail end -->
    <span class="donation-time mb-3 d-block">--</span>
    
  </div>
</div>

@push('after-scripts')
<script>
    $(document).ready(function(){
        $('#choose-inspection-{{$inspection->id}}').on('click', function(e) {
            $.ajax({
                type: "POST",
                url: '{{route("frontend.bookings.pickInspection")}}',
                data: {
                    "corporation_id" : "{{auth()->user()->id}}",
                    "inspection_id" : "{{$inspection->id}}",
                    "status" : "Picked",
                    "_method":"POST",
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                  if(response.isPicked){

                    console.log($(this));
                    $('#choose-inspection-{{$inspection->id}}').removeClass( 'btn-success');
                    $('#choose-inspection-{{$inspection->id}}').addClass( 'btn-danger');
                    $('#choose-inspection-{{$inspection->id}}').html( 'batal');

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

                    $('#choose-inspection-{{$inspection->id}}').removeClass( 'btn-danger');
                    $('#choose-inspection-{{$inspection->id}}').addClass( 'btn-success');
                    $('#choose-inspection-{{$inspection->id}}').html( 'pilih');
                    
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