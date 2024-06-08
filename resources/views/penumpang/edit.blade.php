@extends('layouts.app')
@section('title', 'Edit Akun')
@section('heading', 'Edit Akun')
@section('styles')
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<style>
  /* Styles here */
</style>
@endsection
@section('content')
<div class="card shadow mb-4 mt-2">
  <form action="{{ route('penumpang.update', $penumpang->id) }}" method="POST">
    @csrf
    @method('PUT') <!-- This line specifies that this form will be submitted as a PUT request -->
    <div class="modal-body">
        <div class="form-group">
          <label for="name">Nama User</label>
          <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            placeholder="Nama User"
            value="{{ $penumpang->name }}"
            required
          />
        </div>
        <div class="form-group">
          <label for="username">Username</label>
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            placeholder="Username"
            value="{{ $penumpang->username }}" <!-- Add this line to populate the input with existing value -->
            required
          />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            placeholder="Password"
            required
          />
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('penumpang.index') }}" class="btn btn-warning mr-2">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
@endsection
@section('script')
<script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
<script>
  if (jQuery().select2) {
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
