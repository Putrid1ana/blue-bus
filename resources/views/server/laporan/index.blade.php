@extends('layouts.app')

@section('title', 'Laporan')
@section('heading', 'Laporan')
@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendor/datepicker/datepicker3.css') }}" rel="stylesheet" />
<style>
  thead>tr>th,
  tbody>tr>td {
    vertical-align: middle !important;
  }

  .card-title {
    float: left;
    font-size: 1.1rem;
    font-weight: 400;
    margin: 0;
  }

  .card-text {
    clear: both;
  }

  small {
    font-size: 80%;
    font-weight: 400;
  }

  .text-muted {
    color: #6c757d !important;
  }

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
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
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
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-modal">
      <i class="fas fa-plus"></i>
    </button>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Tujuan</th>
            <th>Armada</th>
            <th>Bukti Pembayaran</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($laporan as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($data->penumpang)->name ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($data->tanggal_pemesanan)->format('d-m-Y') }}</td>
            <td>{{ $data->waktu }}</td>
            <td>{{ optional($data->rute)->tujuan ?? 'N/A' }}</td>
            <td>{{ optional($data->armada)->name ?? 'N/A' }}</td>
            <td>
              @if($data->bukti_pembayaran)
              <a href="{{ asset('storage/' . $data->bukti_pembayaran) }}" target="_blank">Lihat Bukti</a>
              @else
              Tidak ada bukti
              @endif
            </td>
            <td class="text-center">
              <form action="{{ route('transaksi.destroy', $data->id) }}" method="POST">
                @csrf
                @method('delete')
                <a href="{{ route('transaksi.edit', $data->id) }}" class="btn btn-warning btn-sm btn-circle">
                  <i class="fas fa-edit"></i>
                </a>
                <button type="submit" class="btn btn-danger btn-sm btn-circle" onclick="return confirm('Yakin');">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="penumpang_id">Nama</label>
            <select class="select2 form-control" id="penumpang_id" name="penumpang_id" required style="width: 100%; color: #6e707e;">
              <option value="" disabled selected>-- Pilih Penumpang --</option>
              @foreach ($penumpang as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
        <div class="form-group">
          <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
          <input type="date" class="select2 form-control datepicker" id="tanggal_pemesanan" name="tanggal_pemesanan" required style="width: 100%; color: #6e707e;">
        </div>
        <div class="form-group">
          <label for="waktu">Waktu</label>
          <input type="time" class="form-control timepicker" id="waktu" name="waktu" required>
        </div>
        <div class="form-group">
          <label for="rute_id">Tujuan</label>
          <select class="select2 form-control" id="rute_id" name="rute_id" required style="width: 100%; color: #6e707e;">
            <option value="" disabled selected>-- Pilih Tujuan --</option>
            @foreach ($rute as $data)
            <option value="{{ $data->id }}">{{ $data->tujuan }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="armada_id">Armada</label>
          <select class="select2 form-control" id="armada_id" name="armada_id" required>
            <option value="" disabled selected>-- Pilih Armada --</option>
            @foreach ($transportasi as $data)
            <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->name }}</option>
            @endforeach
          </select>
        </div>
          <div class="form-group">
            <label for="bukti_pembayaran">Bukti Pembayaran</label>
            <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" required>
            <small class="form-text text-muted">Unggah foto atau teks bukti pembayaran disini.</small>
          </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/timepicker/jquery.timepicker.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
    $('#penumpang_id').select2();
    $('#rute_id').select2();
    $('#armada_id').select2();
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });
    $('.timepicker').timepicker({
      timeFormat: 'HH:mm:ss',
      interval: 30,
      minTime: '00:00am',
      maxTime: '11:30pm',
      defaultTime: '00:00',
      startTime: '00:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
  });
</script>
@endsection