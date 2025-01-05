@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Daftar Mobil</h3>
            <a href="{{route('admin.cars.create')}}" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mobil</th>
                            <th>Gambar Mobil</th>
                            <th>Harga Sewa</th>
                            <th>Status Mobil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$car->nama_mobil}}</td>
                                <td>
                                    <img src="{{Storage::url($car->gambar)}}" width="200">
                                </td>
                                <td>{{$car->harga_sewa}}</td>
                                <td>{{$car->status}}</td>
                                <td>
                                <a href="{{route('admin.cars.edit', $car->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                <form id="delete-form-{{ $car->id }}" class="d-inline" action="{{ route('admin.cars.destroy', $car->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $car->id }})">Delete</button>
                                </form>
                                
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        function confirmDelete(messageId) {
                                            Swal.fire({
                                                title: "Yakin dihapus?",
                                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya, Hapus!",
                                                cancelButtonText: "Batal"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Submit the corresponding form
                                                    document.getElementById(`delete-form-${messageId}`).submit();
                                                    Swal.fire({
                                                        title: "Berhasil Dihapus!",
                                                         text: "Data Berhasil Dihapus",
                                                          icon: "success"
                                                     });
                                                }
                                            });
                                        }
                                    </script>                               
                    
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection