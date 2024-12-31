@extends('layouts.frontend')

@section('content')

<header class="bg-dark py-5">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bolder">Pemesanan</h1>
    </div>
  </div>
</header>
<!-- Section-->
<section class="py-5">
  <div class="container px-4 px-lg-5 mt-">

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{session()->get('message')}}
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

      <div class="container px-4 px-lg-5 mt-5">
        <div class="d-flex flex-wrap align-items-center">
            <!-- Gambar Mobil -->
            <div class="car-image me-4" style="position: relative; top: -20px;">
            <img class="card-img-top" src="{{ Storage::url($car->gambar) }}" alt="{{$car->nama_mobil}}" style="width: 600px; height: auto; object-fit: cover;">
        </div>
            <!-- Informasi Mobil -->
            <div class="card-body card-body-custom pt-10">
                <div class="text-start">
                    <!-- Nama Produk -->
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bolder">{{$car->nama_mobil}}</h5>
                        <div class="rent-price mb-3">
                            <span style="font-size: 1rem" class="text-primary">Rp.{{ number_format($car->harga_sewa, 0, ',', '.') }}/</span>day
                        </div>
                    </div>
                    <!-- Detail -->
                    <ul class="list-unstyled list-style-group">
                        <li class="border-bottom p-2 d-flex justify-content-between">
                            <span>Bahan Bakar</span>
                            <span style="font-weight: 600">{{$car->bahan_bakar}}</span>
                        </li>
                        <li class="border-bottom p-2 d-flex justify-content-between">
                            <span>Jumlah Kursi</span>
                            <span style="font-weight: 600">{{$car->jumlah_kursi}}</span>
                        </li>
                        <li class="border-bottom p-2 d-flex justify-content-between">
                            <span>Transmisi</span>
                            <span style="font-weight: 600">{{$car->transmisi}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row justify-content-center">
      <div class="col-lg-10 m-auto">
        <div class="bayar-form">
          <form action="{{ route('bayars.store', ['car' => $car->slug]) }}" method="post">
            @csrf

            <input type="hidden" name="mobil" id="mobil" value="{{ $car->nama_mobil }}">
            <input type="hidden" name="harga" id="harga" value="{{ $car->harga_sewa }}">

            <div class="row">
              <div class="col-12 mb-2">
                <div class="name-input form-group">
                  <input
                    type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Isikan nama lengkap"
                  />
                </div>
              </div>

              <div class="col-12 mb-2">
                <div class="email-input form-group">
                  <input
                    type="nomor"
                    name="nomor"
                    class="form-control"
                    placeholder="Isikan nomor handphone"
                  />
                </div>
              </div>
              <div class="col-12 mb-2">
                <div class="days-input form-group">
                    <input
                        type="number"
                        name="hari"
                        class="form-control"
                        placeholder="Isikan jumlah hari penyewaan"
                        min="1" required
                    />
                </div>
            </div>
            </div>
            <div class="input-submit form-group">
              <button
                type="submit"
                style="height: 50px; width: 400px; margin: 0 auto"
                class="d-block btn btn-primary" id="pay-button">Sewa
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
