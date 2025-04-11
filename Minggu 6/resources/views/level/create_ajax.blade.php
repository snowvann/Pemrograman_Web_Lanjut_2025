<<form action="{{ url('/level') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Level Ajax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="level_kode">Kode Level</label>
                    <input type="text" name="level_kode" class="form-control" id="level_kode" required>
                    <div id="error-level_kode" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="level_name">Nama Level</label>
                    <input type="text" name="level_name" class="form-control" id="level_name" required>
                    <div id="error-level_name" class="invalid-feedback"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>


<script>
$(document).ready(function () {
    $('#form-tambah').validate({
        rules: {
            level_kode: { required: true, maxlength: 100 },
            level_name: { required: true, minlength: 3, maxlength: 100 }
        },
        messages: {
            level_kode: {
                required: "Kode level wajib diisi.",
                maxlength: "Kode level maksimal 100 karakter."
            },
            level_name: {
                required: "Nama level wajib diisi.",
                minlength: "Nama level minimal 3 karakter.",
                maxlength: "Nama level maksimal 100 karakter."
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: "json",
                success: function (response) {
                    $('.invalid-feedback').text('');
                    $('.form-control').removeClass('is-invalid');

                    if (response.status) {
                        $('#modalTambah').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        });

                        if (typeof dataLevel !== 'undefined') {
                            dataLevel.ajax.reload();
                        }

                        form.reset();
                    } else {
                        // tampilkan error dari validasi Laravel
                        $.each(response.msgField, function (field, messages) {
                            const input = $('#'+field);
                            input.addClass('is-invalid');
                            $('#error-' + field).text(messages[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Silakan coba lagi.'
                    });
                    console.error(xhr.responseText);
                }
            });
            return false;
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});

</script>
