@extends('layouts.frontend')

@section('content')

<header class="bg-dark py-5">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bolder">Pemesanan</h1>
    </div>
  </div>
</header>

<!-- Section -->
<section class="py-5">
  <div class="container px-4 px-lg-5 mt-5">

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session()->get('message') }}
    </div>
    @endif
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-10 col-sm-12">
        <div class="card shadow-lg border-light">
          <div class="card-body">

            <h4 class="fw-bolder text-center mb-4">Form Penyewaan Mobil</h4>

            <form action="{{ route('bayars.store', ['car' => $car->slug]) }}" method="post">
              @csrf

              <input type="hidden" name="mobil" id="mobil" value="{{ $car->nama_mobil }}">
              <input type="hidden" name="harga" id="harga" value="{{ $car->harga_sewa }}">

              <!-- Kolom Detail Mobil -->
              <div class="mb-4">
                <h5 class="fw-bolder text-dark mb-2">{{ $car->nama_mobil }}</h5>
                <p class="text-primary fs-4 mb-3">Rp.{{ number_format($car->harga_sewa, 0, ',', '.') }}/day</p>
                <ul class="list-unstyled">
                  <li class="d-flex align-items-center mb-2">
                    <i class="bi bi-fuel-pump text-primary me-2" style="font-size: 1.5rem;"></i>
                    <span><strong>Bahan Bakar:</strong> {{$car->bahan_bakar}}</span>
                  </li>
                  <li class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-fill text-primary me-2" style="font-size: 1.5rem;"></i>
                    <span><strong>Jumlah Kursi:</strong> {{$car->jumlah_kursi}}</span>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-gear-fill text-primary me-2" style="font-size: 1.5rem;"></i>
                    <span><strong>Transmisi:</strong> {{$car->transmisi}}</span>
                  </li>
                </ul>
              </div>

              <!-- Form Penyewaan -->
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input
                  type="text"
                  name="nama"
                  class="form-control"
                  placeholder="Isikan nama lengkap"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="nomor" class="form-label">Nomor Handphone</label>
                <input
                  type="text"
                  name="nomor"
                  class="form-control"
                  placeholder="Isikan nomor handphone"
                  required
                />
              </div>

              <div class="mb-4">
                <label for="hari" class="form-label">Jumlah Hari Penyewaan</label>
                <div class="col-2">
                  <input
                    type="number"
                    name="hari"
                    class="form-control"
                    placeholder="Jumlah hari penyewaan"
                    min="1"
                    required
                  />
                </div>
              </div>

              <div class="d-flex justify-content-center">
                <button
                  type="button"
                  class="btn btn-danger w-100 w-md-auto me-2 mb-3 mb-md-0"
                  onclick="location.href='/';">
                  Batal
                </button>
                <button
                  type="submit"
                  class="btn btn-primary w-100 w-md-auto"
                  id="pay-button">
                  Sewa Sekarang
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

  </div>
</section>

@endsection
