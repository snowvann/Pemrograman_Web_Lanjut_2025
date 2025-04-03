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
        <table class="table table-bordered table-hover table-sm" id="table_level">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="levelModal" tabindex="-1" role="dialog" aria-labelledby="levelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="levelModalLabel">Tambah/Edit Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="levelForm">
                    <div class="form-group">
                        <label for="level_kode">Kode Level:</label>
                        <input type="text" name="level_kode" id="level_kode" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="level_name">Nama Level:</label>
                        <input type="text" name="level_name" id="level_name" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanLevel">Simpan</button>
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
                <p>Apakah Anda yakin ingin menghapus level ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="hapusLevel">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    var datalevel = $('#table_level').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('level/list') }}",
            dataType: "json",
            type: "POST"
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "level_kode", orderable: true, searchable: true },
            { data: "level_name", orderable: true, searchable: true },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });

    // Fungsi untuk menampilkan modal tambah
    window.modalTambah = function() {
        $('#levelModal').modal('show');
        $('#levelModalLabel').text('Tambah Level');
        $('#levelForm')[0].reset();
        $('#simpanLevel').attr('data-id', '');
    };

    // Fungsi untuk menampilkan modal edit
    window.modalEdit = function(id) {
        $.ajax({
            url: "{{ url('/level') }}/" + id + "/edit_ajax",
            type: "GET",
            success: function(response) {
                $('#levelModal').modal('show');
                $('#levelModalLabel').text('Edit Level');
                $('#level_name').val(response.level.level_name);
                $('#simpanLevel').attr('data-id', id);
            }
        });
    };

    // Fungsi untuk menampilkan modal hapus
    window.modalHapus = function(id) {
        $('#hapusModal').modal('show');
        $('#hapusLevel').attr('data-id', id);
    };

    // Validasi dan AJAX untuk simpan/update data
    $('#simpanLevel').click(function() {
    $('#levelForm').validate({
        rules: {
            level_kode: {
                required: true,
                minlength: 3,
                remote: {
                    url: "{{ route('level.check_unique') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        level_kode: function() {
                            return $("#level_kode").val();
                        },
                        id: $(this).attr('data-id'),
                    }
                }
            },
            level_name: {
                required: true,
                maxlength: 100,
                remote: {
                    url: "{{ route('level.check_unique') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        level_name: function() {
                            return $("#level_name").val();
                        },
                        id: $(this).attr('data-id'),
                    }
                }
            }
        },
        messages: {
            level_kode: {
                required: "Kode level harus diisi.",
                minlength: "Kode level minimal 3 karakter.",
                remote: "Kode level sudah ada."
            },
            level_name: {
                required: "Nama level harus diisi.",
                maxlength: "Nama level maksimal 100 karakter.",
                remote: "Nama level sudah ada."
            }
        },
            submitHandler: function(form) {
            var id = $('#simpanLevel').attr('data-id');
            var url = id ? "{{ url('/level') }}/" + id + "/update_ajax" : "{{ route('level.store_ajax') }}";
            var type = id ? "PUT" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $('#levelModal').modal('hide');
                        datalevel.ajax.reload();
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
    $('#levelForm').submit();
});

    // AJAX untuk hapus data
    $('#hapusLevel').click(function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('/level') }}/" + id + "/delete_ajax",
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    $('#hapusModal').modal('hide');
                    datalevel.ajax.reload();
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