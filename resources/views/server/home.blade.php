@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Data Rute</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rute }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-route fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Data Armada</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transportasi }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-subway fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Data User</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bagian Baru untuk Gambar di Bawah -->
  <div class="row">
    <div class="col-xl-6 col-md-12 mb-4">
      <div class="card shadow h-100 py-2">
        <div class="card-body text-center">
          <img src="{{ asset('img/bus6.jpg') }}" class="img-src" alt="Descriptive Alt Text">
          <p>layanan bus yang sangat nyaman dan dilengkapi beberapa fasilitas yang lengkap yang akan menemani perjalanan anda</p>
        </div>
      </div>
    </div>
    <style>
    .img-src {
      max-width: 60%;
      height: auto;
    }
  </style>
    <div class="col-xl-6 col-md-12 mb-4">
      <div class="card shadow h-100 py-2">
        <div class="card-body text-center">
          <img src="{{ asset('img/bus7.jpg') }}" class="img-src" alt="Descriptive Alt Text">
          <p>layanan bus yang sangat nyaman dan dilengakapi beberapa fasilitas yang lengkap akan menemani perjalanan anda </p>
        </div>
      </div>
    </div>
  </div>

  <style>
    .img-src {
      max-width: 60%;
      height: auto;
    }
  </style>
@endsection
