<tr>
    <td>
        {{ $rowId }}
    </td>
    <td>
        <select class="form-control" name="kode[]">
            <option value="" selected disabled>Pilih</option>
            @foreach ($ref as $r)
            <option value="{{ $r->kode }}">{{ $r->uraian }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control" name="nama_barang[]">
    </td>
    <td>
        <input type="text" class="form-control" name="satuan[]">
    </td>
    <td>
        @if ($rowId!==1)

        <a href="" class="btn btn-danger hapus-btn" wire:click.prevent="deleteRow({{ $rowId }})">Hapus</a>
        @endif
    </td>
</tr>