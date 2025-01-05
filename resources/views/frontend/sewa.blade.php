@extends('layouts.frontend')

@section('content')

<header class="bg-dark py-5">
  <div class="container px-4 px-lg-5 my-5">
    <div class="text-center text-white">
      <h1 class="display-4 fw-bolder">Pembayaran</h1>
    </div>
  </div>
</header>
<!-- Section-->
<section class="py-5">
  <div class="card-body card-body-custom pt-10">
    <div class="text-center">
      <h3 class="mb-4">Detail Penyewaan</h3>
      <!-- Mobil -->
      <ul class="list-unstyled list-style-group mx-auto" style="max-width: 400px;">
        <li class="border-bottom p-2 d-flex justify-content-between">
          <span>Mobil</span>
          <span style="font-weight: 600">{{ $bayars->mobil }}</span>
        </li>
        <li class="border-bottom p-2 d-flex justify-content-between">
          <span>Total Harga</span>
          <span class="fw-bold text-dark">Rp{{ number_format($bayars->harga_total, 0, ',', '.') }}</span>
        </li>
        <li class="border-bottom p-2 d-flex justify-content-between">
          <span>Nama</span>
          <span style="font-weight: 600">{{ $bayars->nama }}</span>
        </li>
        <li class="border-bottom p-2 d-flex justify-content-between">
          <span>Nomor handphone</span>
          <span style="font-weight: 600">{{ $bayars->nomor }}</span>
        </li>
      </ul>
      <button
        type="button"
        style="height: 50px; width: 200px;"
        class="btn btn-danger"
        onclick="location.href='/';">
        Batal
      </button>
      <button
        type="button"
        style="height: 50px; width: 200px;"
        class="btn btn-primary" 
        id="checkout-button">
        Bayar Sekarang
      </button>
    </div>
  </div>

  <script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>

  <script>
    document.getElementById('checkout-button').addEventListener('click', async () => {
        try {
            // Get the payment URL from the response passed from the controller
            const paymentUrl = "{{ $paymentUrl ?? '' }}";

            if (!paymentUrl) {
                throw new Error('Payment URL not found');
            }

            // Trigger Doku Checkout
            loadJokulCheckout(paymentUrl);
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    });
  </script>

</section>

@endsection
