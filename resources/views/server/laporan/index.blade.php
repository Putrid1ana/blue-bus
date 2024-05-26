@extends('layouts.app')
@section('title', 'Laporan')
@section('heading', 'Laporan')
@section('styles')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
  <style>
    thead > tr > th, tbody > tr > td {
      vertical-align: middle !important;
    }

    .card-title {
      float: left;
      font-size: 1.1rem;
      font-weight: 400;
      margin: 0;
    }

    .ctr {
      text-align: center !important;
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
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-primary btn-sm"
      data-toggle="modal"
      data-target="#add-modal"
    >
      <i class="fas fa-plus"></i>
    </button>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table
        class="table table-bordered table-striped table-hover"
        id="dataTable"
        width="100%"
        cellspacing="0"
      >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>Tanggal Pemesanan</th>
            <th>Tujuan</th>
            <th>Armada</th>
            <th>Harga Tiket</th>
            <th>Transaksi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pemesanan as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->penumpang->user->name }}</td>
              <td>{{ $data->created_at->format('d-m-Y') }}</td>
              <td>{{ $data->rute->tujuan }}</td>
              <td>{{ $data->rute->transportasi->name }}</td>
              <td>{{ number_format($data->transaksi, 2) }}</td>
              <td class="text-center">
                <form action="{{ route('transaksi.destroy', $data->id) }}" method="POST">
                  @csrf
                  @method('delete')
                  <a href="{{ route('transaksi.edit', $data->id) }}" type="button" class="btn btn-warning btn-sm btn-circle">
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
<div
  class="modal fade"
  id="add-modal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="exampleModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan</h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group">
            <label for="user_id">Nama User</label>
            <select class="form-control" id="user_id" name="user_id" required style="width: 100%; color: #6e707e;">
              <option value="" disabled selected>-- Pilih User --</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="tujuan">Tujuan</label>
            <input
              type="text"
              class="form-control"
              id="tujuan"
              name="tujuan"
              placeholder="Tujuan"
              required
            />
          </div>
          <div class="form-group">
            <label for="transportasi_id">Armada</label><br>
            <select class="form-control" id="transportasi_id" name="transportasi_id" required style="width: 100%; color: #6e707e;">
              <option value="" disabled selected>-- Pilih Armada --</option>
              @foreach ($transportasi as $data)
              <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="harga">Harga</label>
            <input
              type="text"
              class="form-control"
              id="harga"
              name="harga"
              onkeypress="return inputNumber(event)"
              placeholder="Harga"
              required
            />
          </div>
          <div class="form-group">
            <label for="pembayaran">Pembayaran</label>
            <input type="text" class="form-control" id="pembayaran" name="pembayaran" placeholder="Pembayaran" required />
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
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable();
    $('.select2').select2();

    function inputNumber(e) {
      const charCode = (e.which) ? e.which : e.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    }
  });
</script>
@endsection
