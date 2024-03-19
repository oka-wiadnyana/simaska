<div>
    <div class="modal {{ $showEditModal?'show':'fade' }}" id="myExampleModal" style="display: @if($showEditModal === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Referensi Barang</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="closeEditModal()"></button>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ url('goods/editrefbarang') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ $data->nama_barang??"" }}">
                        </div>
                        <div class="form-group">
                            <label for="">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="{{ $data->satuan??"" }}">
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id??"" }}">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"
                        wire:click.prevent="closeEditModal()">Cancel</button>

                </div>

            </div>
        </div>
    </div>
    <!-- Let's also add the backdrop / overlay here -->
    <div class="modal-backdrop {{ $showEditModal?'show':'fade' }}" id="backdrop" style="display: @if($showEditModal === true)
                 block
         @else
                 none
         @endif;">{{ $showEditModal }}</div>
</div>