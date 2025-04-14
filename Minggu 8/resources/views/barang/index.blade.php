@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Barang</h3>
        <div class="card-tools">
        <a href="{{ url('/barang/import/') }}" class="btn btn-primary">Import</a>
        <a href="{{ url('/barang/create_ajax/') }}" class="btn btn-primary">Tambah Data</a> 
        <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Barang</a>
            
        <!-- <button onclick="modalAction('{{ url('/barang/import/') }}')" class="btn btn-info">Import Barang</button> 
        <a href="{{ url('/barang/create') }}" class="btn btn-primary">Tambah Data</a> 
        <button onclick="modalAction('{{ url('/barang/create_ajax/') }}')" class="btn btn-success">Tambah Data (Ajax)</button> -->
        </div>
    </div>
    <div class="card-body">
        <!-- Filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row mb-0">
                        <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                <option value="">- Semua -</option>
                                @foreach($kategori as $l)
                                    <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-sm table-striped table-hover" id="table-barang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        if (url) {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }
    }

    $(document).ready(function () {
        // Tombol Import
        $('#btnImport').on('click', function () {
            modalAction("{{ url('/barang/import/') }}");
        });

        // Tombol Create AJAX
        $('#btnCreateAjax').on('click', function () {
            modalAction("{{ url('/barang/create_ajax/') }}");
        });

        var tableBarang = $('#table-barang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('barang/list') }}",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.filter_kategori = $('.filter_kategori').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang_kode",
                    width: "10%",
                },
                {
                    data: "barang_nama",
                    width: "37%",
                },
                {
                    data: "harga_beli",
                    width: "10%",
                    render: function (data) {
                        return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "harga_jual",
                    width: "10%",
                    render: function (data) {
                        return new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "kategori.kategori_nama",
                    width: "14%",
                },
                {
                    data: "aksi",
                    className: "text-center",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Enter key to trigger search
        $('#table-barang_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode === 13) {
                tableBarang.search(this.value).draw();
            }
        });

        // Filter kategori
        $('.filter_kategori').change(function () {
            tableBarang.draw();
        });
    });
</script>
@endpush
