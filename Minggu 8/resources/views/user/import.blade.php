@extends('layouts.template')

@section('content')
<div class="container">
    <h4>Import Data User</h4>
    <form action="{{ url('/user/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Download Template</label><br>
            <a href="{{ asset('template_user.xlsx') }}" class="btn btn-info btn-sm" download>
                <i class="fa fa-file-excel"></i> Download Template
            </a>
        </div>
        <div class="form-group">
            <label for="file_barang">Pilih File (.xlsx)</label>
            <input type="file" name="file_barang" id="file_barang" class="form-control" required>
            <small id="error-file_barang" class="error-text form-text text-danger"></small>
        </div>
        <a href="{{ url('/user') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("#form-import").validate({
            rules: {
                file_barang: {
                    required: true,
                    extension: "xlsx"
                }
            },
            messages: {
                file_barang: {
                    required: "Silakan pilih file untuk diupload.",
                    extension: "File harus berformat .xlsx"
                }
            },
            submitHandler: function (form) {
                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                window.location.href = '/user';
                            });
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Upload',
                            text: 'Terjadi kesalahan saat mengupload file.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection
