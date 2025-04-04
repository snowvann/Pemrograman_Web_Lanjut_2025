@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" onclick="modalTambah()">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table id="supplierTable" class="table table-bordered table-striped">
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

<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Tambah/Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="supplierForm">
                    <div class="form-group">
                        <label for="supplier_kode">Kode Supplier:</label>
                        <input type="text" name="supplier_kode" id="supplier_kode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="supplier_nama">Nama Supplier:</label>
                        <input type="text" name="supplier_nama" id="supplier_nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat_supplier">Alamat Supplier:</label>
                        <textarea name="alamat_supplier" id="alamat_supplier" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanSupplier">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus supplier ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="hapusSupplier">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/supplier/list",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'supplier_id', name: 'supplier_id' },
            { data: 'supplier_kode', name: 'supplier_kode' },
            { data: 'supplier_nama', name: 'supplier_nama' },
            { data: 'alamat_supplier', name: 'alamat_supplier' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]
    });

    window.modalTambah = function() {
        $('#supplierModal').modal('show');
        $('#supplierModalLabel').text('Tambah Supplier');
        $('#supplierForm')[0].reset();
        $('#simpanSupplier').attr('data-id', '');
    };

    window.modalEdit = function(id) {
        $.ajax({
            url: "{{ url('/supplier') }}/" + id + "/edit_ajax",
            type: "GET",
            success: function(response) {
                $('#supplierModal').modal('show');
                $('#supplierModalLabel').text('Edit Supplier');
                $('#supplier_kode').val(response.supplier.supplier_kode);
                $('#supplier_nama').val(response.supplier.supplier_nama);
                $('#alamat_supplier').val(response.supplier.alamat_supplier);
                $('#simpanSupplier').attr('data-id', id);
            }
        });
    };

    window.modalHapus = function(id) {
        $('#hapusModal').modal('show');
        $('#hapusSupplier').attr('data-id', id);
    };

    $('#simpanSupplier').click(function() {
        $('#supplierForm').validate({
            rules: {
                supplier_kode: {
                    required: true,
                    maxlength: 10,
                    remote: {
                        url: "{{ url('/supplier/check_unique') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            supplier_kode: function() {
                                return $("#supplier_kode").val();
                            },
                            id: $(this).attr('data-id'),
                        }
                    }
                },
                supplier_nama: {
                    required: true,
                    maxlength: 100
                },
                alamat_supplier: {
                    required: true
                }
            },
            messages: {
                supplier_kode: {
                    required: "Kode supplier harus diisi.",
                    maxlength: "Kode supplier maksimal 10 karakter.",
                    remote: "Kode supplier sudah ada."
                },
                supplier_nama: {
                    required: "Nama supplier harus diisi.",
                    maxlength: "Nama supplier maksimal 100 karakter."
                },
                alamat_supplier: {
                    required: "Alamat supplier harus diisi."
                }
            },
            submitHandler: function(form) {
                var id = $('#simpanSupplier').attr('data-id');
                var url = id ? "{{ url('/supplier') }}/" + id + "/update_ajax" : "{{ url('/supplier/store_ajax') }}";
                var type = id ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    type: type,
                    data: $(form).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            $('#supplierModal').modal('hide');
                            table.ajax.reload();
                        } else {
                            if (response.msgField) {
                                // Tampilkan pesan kesalahan validasi
                                var errors = '';
                                $.each(response.msgField, function(key, value) {
                                    errors += value[0] + '<br>';
                                });
                                alert('Validasi gagal:\n' + errors);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
        $('#supplierForm').submit();
    });

    $('#hapusSupplier').click(function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('/supplier') }}/" + id + "/delete_ajax",
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    $('#hapusModal').modal('hide');
                    table.ajax.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script>
@endpush