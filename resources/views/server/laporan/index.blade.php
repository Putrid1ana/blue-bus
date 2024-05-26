@extends('layouts.app')

@section('title', 'Laporan')
@section('heading', 'Laporan')
@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
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
                        <th>Tanggal Pemesanan</th>
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
                        <td>{{ $data->penumpang->user->name }}</td>
                        <td>{{ $data->tanggal_pemesanan->format('d-m-Y') }}</td>
                        <td>{{ $data->tujuan }}</td>
                        <td>{{ $data->armada->name }}</td>
                        <td>{{ $data->bukti_pembayaran }}</td>
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
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="penumpang_id">Nama Penumpang</label>
                        <select class="form-control" id="penumpang_id" name="penumpang_id" required>
                            <option value="" disabled selected>-- Pilih Penumpang --</option>
                            @foreach ($penumpang as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" name="tujuan" placeholder="Tujuan" required />
                    </div>
                    <div class="form-group">
                        <label for="armada_id">Armada</label>
                        <select class="form-control" id="armada_id" name="armada_id" required>
                            <option value="" disabled selected>-- Pilih Armada --</option>
                            @foreach ($transportasi as $data)
                            <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Pembayaran</label>
                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran">
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
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('#penumpang_id').select2();
        $('#armada_id').select2();
    });
</script>
@endsection
