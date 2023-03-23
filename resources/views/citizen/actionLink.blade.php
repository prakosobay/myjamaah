<a href="{{ route('citizenView', $model->id)}}" class="btn-success btn-sm btn mx-1 my-1">Detail</a>
<a href="{{ route('citizenEdit', $model->id)}}" class="btn-warning btn-sm btn mx-1 my-1">Perbarui</a>
<form action="{{ route('citizenDelete', $model->id) }}" method="POST" onsubmit="return confirm('Anda Yakin ingin Menghapus ?')">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm mx-1 my-1"><i class="glyphicon glyphicon-edit"></i>Hapus</button>
</form>
