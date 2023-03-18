<a href="{{ route('petugas.edit', $model->id)}}" class="btn btn-xs btn-primary mx-1 my-1"><i class="glyphicon glyphicon-checkout"></i>Update</a>
<form action="{{ route ('petugas.delete', $model->id) }}" method="POST" onsubmit="return confirm('Anda Yakin ingin Menghapus ?')">
    @csrf
    <button type="submit" class="btn btn-xs btn-danger mx-1 my-1"><i class="glyphicon glyphicon-edit"></i>Hapus</button>
</form>

