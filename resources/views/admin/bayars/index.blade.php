@extends('layouts.admin')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Daftar Pembayaran Sewa Mobil</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mobil</th>
                            <th>Harga Sewa</th>
                            <th>Jumlah Hari</th>
                            <th>Harga Total</th>
                            <th>Nama</th>
                            <th>Nomor Handphone</th>
                            <th>Invoice</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bayars as $bayar)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$bayar->mobil}}</td>
                                <td>Rp{{ number_format($bayar->harga, 0, ',', '.') }}</td>
                                <td>{{$bayar->hari}}</td>
                                <td>Rp{{ number_format($bayar->harga_total, 0, ',', '.') }}</td>
                                <td>{{$bayar->nama}}</td>
                                <td>{{$bayar->nomor}}</td>
                               
                                <td>                              
                                    <a href="/invoice/{{ $bayar->orders_id }}" class="btn btn-primary btn-sm">Invoice</a>                                 
                                <td>
                                    <form id="delete-form-{{ $bayar->orders_id }}" class="d-inline" action="{{ route('admin.bayars.destroys', $bayar->orders_id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $bayar->orders_id }}">Delete</button>
                                    </form>
                                    
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const deleteButtons = document.querySelectorAll('.delete-button');
                                            deleteButtons.forEach(button => {
                                                button.addEventListener('click', function () {
                                                    const orderId = this.getAttribute('data-id');
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
                                                            document.getElementById(`delete-form-${orderId}`).submit();
                                                            Swal.fire({
                                                                title: "Berhasil Dihapus!",
                                                                text: "Data Berhasil Dihapus",
                                                                icon: "success"
                                                             });
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                    </script>
                                    
                                    
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data Kosong</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection