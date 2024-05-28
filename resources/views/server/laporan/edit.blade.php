@extends('layouts.app')

@section('title', 'Edit Laporan')
@section('heading', 'Edit Laporan')
@section('styles')
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="card shadow mb-4">
    <form action="{{ route('transaksi.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="form-group">
                <label for="penumpang_id">Nama</label>
                <select class="select2 form-control" id="penumpang_id" name="penumpang_id" required style="width: 100%; color: #6e707e;">
                    <option value="" disabled>-- Pilih Penumpang --</option>
                    @foreach ($penumpang as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $laporan->penumpang_id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                <input type="date" class="form-control datepicker" id="tanggal_pemesanan" name="tanggal_pemesanan" value="{{ $laporan->tanggal_pemesanan }}" required>
            </div>
            <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="time" class="form-control timepicker" id="waktu" name="waktu" value="{{ $laporan->waktu }}" required>
            </div>
            <div class="form-group">
                <label for="rute_id">Tujuan</label>
                <select class="select2 form-control" id="rute_id" name="rute_id" required style="width: 100%; color: #6e707e;">
                    <option value="" disabled>-- Pilih Tujuan --</option>
                    @foreach ($rute as $data)
                    <option value="{{ $data->id }}" {{ $data->id == $laporan->rute_id ? 'selected' : '' }}>{{ $data->tujuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="armada_id">Armada</label>
                <select class="select2 form-control" id="armada_id" name="armada_id" required>
                    <option value="" disabled>-- Pilih Armada --</option>
                    @foreach ($transportasi as $data)
                    <option value="{{ $data->id }}" {{ $data->id == $laporan->armada_id ? 'selected' : '' }}>{{ $data->kode }} - {{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#penumpang_id').select2();
        $('#armada_id').select2();
    });
</script>
@endsection
