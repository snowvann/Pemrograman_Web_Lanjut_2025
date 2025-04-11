<div class="modal-dialog modal-lg" role="document">
    <form action="{{ url('/supplier') }}" method="POST" id="form-tambah">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier Ajax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
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
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#form-tambah').validate({
        rules: {
            supplier_kode: { required: true, maxlength: 10, minlength: 3 },
            supplier_nama: { required: true, maxlength: 50, minlength: 3 },
            alamat_supplier: { required: true, maxlength: 100, minlength: 3 }
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
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        });

                        if (typeof dataSupplier !== 'undefined') {
                            dataSupplier.ajax.reload();
                        }
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
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
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});

</script>