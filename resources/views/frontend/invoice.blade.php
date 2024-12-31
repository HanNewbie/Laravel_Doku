<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rental Mobil</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('frontend/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}" />
  </head>
  <body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{route('homepage')}}"><strong>RentalIn</strong></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="{{route('homepage')}}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('contact')}}">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </body>

 {{-- INVOICE --}}
 <section class="py-5">
  <div class="card-body pt-10">
    <div class="invoice-container mx-auto" style="max-width: 600px; border: 1px solid #ddd; border-radius: 8px; padding: 30px; background-color: #f9f9f9;">
      <div class="text-center mb-4">
        <h3 class="text-dark">INVOICE</h3>
        <p class="text-muted">Detail Penyewaan Anda</p>
      </div>

      <!-- Invoice Details -->
      <div class="invoice-details">
        <div class="row mb-3">
          <div class="col-6">
            <strong>Nama:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">{{ $bayars->nama }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <strong>Nomor Handphone:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">{{ $bayars->nomor }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <strong>Mobil:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">{{ $bayars->mobil }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <strong>Harga:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">Rp.{{ number_format($bayars->harga, 0, ',', '.') }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <strong>Hari:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">{{ $bayars->hari }}</span>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <strong>Total Harga:</strong>
          </div>
          <div class="col-6 text-end">
            <span class="fw-bold text-dark">Rp{{ number_format($bayars->harga_total, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      <!-- Footer Note -->
      <div class="text-center mt-5">
        <p class="text-muted">Terimakasih telah memilih dan percaya kepada Rentalin!</p>
      </div>
    </div>
  </div>
</section>

<style>
  .invoice-container {
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }
  
  .invoice-details {
    font-family: 'Arial', sans-serif;
  }

  .invoice-details .row {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
  }

  .invoice-details .row:last-child {
    border-bottom: none;
  }

  .text-primary {
    color: #007bff !important;
  }

  .fw-bold {
    font-weight: 600;
  }

  .text-muted {
    color: #6c757d !important;
  }

  .text-dark {
    color: #343a40 !important;
  }
</style>

</html>
