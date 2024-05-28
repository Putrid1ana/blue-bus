@extends('layouts.app')
@section('title', 'Akun')
@section('heading', 'Akun')
@section('styles')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
<style>
  /* Styles here */
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
            <td>No</td>
            <td>Name</td>
            <td>Username</td>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($penumpang as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->username }}</td>
              <td>
                <form action="{{ route('penumpang.destroy', $data->id) }}" method="POST">
                  @csrf
                  @method('delete')
                  <a href="{{ route('penumpang.edit', $data->id) }}" class="btn btn-warning btn-sm btn-circle">
                    <i class="fas fa-edit"></i>
                  </a> <!-- Modified this line -->
                  <button
                    type="submit"
                    class="btn btn-danger btn-sm btn-circle"
                    onclick="return confirm('Yakin');"
                  >
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('penumpang.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama User</label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              placeholder="Nama User"
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Kembali
          </button>
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
  });
  if(jQuery().select2) {
    $(".select2").select2();
  }
</script>
@endsection
