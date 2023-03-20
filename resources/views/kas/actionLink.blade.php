<a type="button" href="{{ route('saldoKas.edit', $model->id) }}" class="btn btn-primary btn-sm mx-1 my-1">
    Update
</a>
<form action="{{ route('saldoKas.delete', $model->id) }}" method="POST" onsubmit="return confirm('Anda Yakin ingin Menghapus ?')">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm mx-1 my-1"><i class="glyphicon glyphicon-edit"></i>Hapus</button>
</form>
