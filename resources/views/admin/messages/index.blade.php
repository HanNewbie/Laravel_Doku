@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Daftar Komplain</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$message->nama}}</td>
                                <td>{{$message->email}}</td>
                                <td>{{$message->subject}}</td>
                                <td>{{$message->pesan}}</td>
                                <td>
                                    <form id="delete-form-{{ $message->id }}" class="d-inline" action="{{ route('admin.messages.destroy', $message->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $message->id }})">Delete</button>
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