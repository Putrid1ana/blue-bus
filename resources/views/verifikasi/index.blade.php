@extends('layouts.app')

@section('title', 'Transaksi')
@section('heading', 'Transaksi')
@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <!-- Button trigger modal -->
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
            <th>NIK</th>
            <th>Nama User</th>
            <th>Telpon</th>
            <th>Nama Armada</th>
            <th>Nomor Kursi</th>
            <th>Sisa Kursi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transaksi as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->nik }}</td>
            <td>{{ $data->penumpang->name }}</td>
            <td>{{ $data->telepon }}</td>
            <td>{{ $data->transportasi->name }}</td>
            <td>{{ $data->nomor_kursi }}</td>
            <td>{{ $data->sisa_kursi }}</td>
            
            <td class="text-center">
              <form action="{{ route('verifikasi.destroy', $data->id) }}" method="POST">
                @csrf
                @method('delete')
                <a href="{{ route('verifikasi.edit', $data->id) }}" type="button" class="btn btn-warning btn-sm btn-circle">
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('verifikasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required />
          </div>
          <div class="form-group">
            <label for="penumpang_id">Nama User</label>
            <select class="form-control select" id="user_id" name="penumpang_id" required style="width: 100%; color: #6e707e;">
              <option value="" disabled selected>-- Pilih User --</option>
              @foreach ($penumpang as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon" required />
          </div>
          <div class="form-group">
            <label for="transportasi_id">Armada</label><br>
            <select class="form-control select" id="transportasi_id" name="transportasi_id" required style="width: 100%; color: #6e707e;">
              <option value="" disabled selected>-- Pilih Armada --</option>
              @foreach ($transportasi as $data)
              <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="nomor_kursi">Nomor Kursi</label>
            <input type="text" class="form-control" id="nomor_kursi" name="nomor_kursi" placeholder="Nomor Kursi" required />
          </div>
          <div class="form-group">
            <label for="sisa_kursi">Sisa Kursi</label>
            <input type="text" class="form-control" id="sisa_kursi" name="sisa_kursi" placeholder="Sisa Kursi" required />
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
    $(".select2").select2();
  });
</script>
@endsection
