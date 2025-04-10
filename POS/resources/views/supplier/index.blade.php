@extends('layouts.template')
 
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('/supplier/create_ajax/') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax Supplier</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="supplier_id" class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value="">- Semua -</option>
                            @foreach ($supplier as $item)
                                <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Supplier Barang</small>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Ajax content akan di-load ke sini -->
    </div>
  </div>
</div>



@endsection
 
@push('css')
<!-- Tambahkan custom CSS di sini jika diperlukan -->
@endpush
 
@push('js')
<script>
    function modalAction(url) {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        var datasupplier = $('#table_supplier').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('supplier/list') }}",
                dataType: "json",
                type: "POST",
                data: function (d) {
                    d.supplier_id = $('#supplier_id').val();
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "supplier_kode", orderable: true, searchable: true },
                { data: "supplier_nama", orderable: true, searchable: true },
                { data: "alamat_supplier", orderable: true, searchable: true },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        $('#supplier_id').on('change', function() {
            datasupplier.ajax.reload();
        });
    });
</script>
@endpush