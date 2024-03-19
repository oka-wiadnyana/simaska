<div>
    <div class="modal {{ $showModal?'show':'fade' }}" id="myExampleModal" style="display: @if($showModal === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Referensi Barang</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent="closeModal()"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <a href="" class="btn btn-info" wire:click.prevent='addRow'>Tambah barang</a>
                        </div>
                    </div>
                    <form action="{{ url('goods/insertrefbarang') }}" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                                <th>No</th>
                                <th>Jenis Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </thead>

                            <tbody>

                                @foreach($inputRows as $row)
                                @livewire('inputbarang',['rowId'=>$row['id']] ,key($row['id']))

                                @endforeach
                            </tbody>


                        </table>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" wire:click.prevent="closeModal()">Cancel</button>

                </div>

            </div>
        </div>
    </div>
    <!-- Let's also add the backdrop / overlay here -->
    <div class="modal-backdrop {{ $showModal?'show':'fade' }}" id="backdrop" style="display: @if($showModal === true)
                 block
         @else
                 none
         @endif;">{{ $showModal }}</div>
</div>