@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('heading', 'Edit Transaksi')
@section('styles')
  <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
  <style>
    .select2-container .select2-selection--single {
      display: block;
      width: 100%;
      height: calc(1.5em + .75rem + 2px);
      padding: .375rem .75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 2;
      color: #6e707e;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #d1d3e2;
      border-radius: .35rem;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #6e707e;
      line-height: 28px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
      display: block;
      padding-left: 0;
      padding-right: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      margin-top: -2px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: calc(1.5em + .75rem + 2px);
      position: absolute;
      top: 1px;
      right: 1px;
      width: 20px;
    }
  </style>
@endsection
@section('content')
  <div class="card shadow mb-4 mt-2">
  <form action="{{ route('verifikasi.update', $transaksi->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="user_id">Nama User</label>
            <select class="form-control" id="user_id" name="user_id" required style="width: 100%; color: #6e707e;">
                <option value="" disabled>-- Pilih User --</option>
                @foreach ($penumpang as $user)
                    <option value="{{ $user->id }}" {{ $transaksi->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="transportasi_id">Armada</label><br>
            <select class="form-control" id="transportasi_id" name="transportasi_id" required style="width: 100%; color: #6e707e;">
                <option value="" disabled>-- Pilih Armada --</option>
                @foreach ($transportasi as $data)
                    <option value="{{ $data->id }}" {{ $transaksi->transportasi_id == $data->id ? 'selected' : '' }}>{{ $data->kode }} - {{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="sisa_kursi">Sisa Kursi</label>
            <input type="text" class="form-control" id="sisa_kursi" name="sisa_kursi" value="{{ $transaksi->sisa_kursi }}" required/>
        </div>
        <div class="form-group">
    <label for="bukti_pembayaran">Bukti Pembayaran</label>
    <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran">
    <small id="bukti_pembayaran_help" class="form-text text-muted">Unggah foto atau teks bukti pembayaran disini.</small>
</div>
    </div>
    <div class="card-footer">
        <a href="{{ route('verifikasi.index') }}" class="btn btn-warning mr-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
  </div>
@endsection
@section('script')
  <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
  <script>
    if(jQuery().select2) {
      $(".select2").select2();
    }
    function inputNumber(e) {
      const charCode = (e.which) ? e.which : w.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    };
  </script>
@endsection
