<div class="modal modal_presensi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Presensi Siang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center mb-2">
                    <span class="fs-5 fw-bold mb-0">
                        Hari {{ $date }}
                    </span>
                    <span class="fs-5 fw-bold ">
                        Saat ini pukul {{ $time }}
                    </span>

                </div>
                <div class=" row px-2 rounded-3 mb-3">
                    <div id="map" style="height: 180px;"></div>
                </div>
                <form action="{{ url('presensi/insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="date" name="tanggal" id="" value={{ $date_input }}>
                    <input type="time" name="pukul" id="" value={{ $time }}>
                    <input type="hidden" name="latitude">
                    <input type="hidden" name="longitude">
                    @if($data_presensi)
                    <span class="fs-5 fw-bold ">
                        Presensi Pukul {{ $data_presensi->pukul }}
                    </span>
                    @endif
                    @if(!$data_presensi)
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @endif
                </form>
            </div>

        </div>
    </div>
</div>
{{-- <script src="{{ asset('geoJson/geo.js') }}"></script> --}}
<script>
    $(document).ready(function () {
        let latitude_pn=-8.6699184;
        let longitude_pn=115.2271162;
        let getLatLong= async ()=>{
       
            return new Promise((resolve,reject)=>{
                if (navigator.geolocation) {
                let coordinate;
                navigator.geolocation.getCurrentPosition(function(position) {
                  
                  coordinate={latitude:position.coords.latitude,longitude:position.coords.longitude}
                  
                   
                  resolve(coordinate);
                });
               
                } else {
                   alert('Lokasi tidak didukung')
                }
            })
                      
        }
       
        
        getLatLong().then(res=>{
          
            $('[name="latitude"]').val(res.latitude);
            $('[name="longitude"]').val(res.longitude);
            var map = L.map('map').setView([res.latitude, res.longitude],13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
           
            var marker = L.marker([res.latitude, res.longitude]).addTo(map);
            var circle = L.circle([latitude_pn, longitude_pn], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 500
                        }).addTo(map);
            // Get L.LatLng object of the circle
            var circleLatLng = circle.getLatLng();

            // Get L.LatLng object of the marker
            var markerLatLng = marker.getLatLng();

            // Calculate distance:
            var distance = circleLatLng.distanceTo(markerLatLng);

            // Use distance in a condition:
            if (distance > 500) {
                // Out of bounds, do stuff
                alert('Anda berada di luar wilayah PT');
                $('.btn-close').trigger('click');
            }

        })

        // console.log('lat',latitude);

        $('input[type="date"]').hide();
        $('input[type="time"]').hide();
    });
</script>