<form action="{{ url('/barang') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Ajax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <div class="modal-body">
            <div class="form-group">
                <label for="kategori_id">Kategori:</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1">BK - Baby Kid</option>
                    <option value="2">BH - Beauty Health</option>
                    <option value="3">FB - Food Beverage</option>
                    <option value="4">HC - Home Care</option>
                </select>
                <small id="error-kategori_id" class="error-text form-text text-danger"></small>
            </div>
                <div class="form-group">
                    <label for="barang_kode">Kode Barang:</label>
                    <input type="text" name="barang_kode" id="barang_kode" class="form-control">
                </div>
                <div class="form-group">
                    <label for="barang_nama">Nama Barang:</label>
                    <input type="text" name="barang_nama" id="barang_nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli:</label>
                    <input type="number" name="harga_beli" id="harga_beli" class="form-control">
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual:</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#form-tambah').validate({
        rules: {
            kategori_id: { required: true, digits: true },
            barang_kode: { required: true, maxlength: 100, minlength: 3 },
            barang_nama: { required: true, maxlength: 255, minlength: 3 },
            harga_beli: { number: true },
            harga_jual: { number: true }
        },
        messages: {
            kategori_id: {
                required: "Kategori ID harus diisi.",
                digits: "Kategori ID harus berupa angka."
            },
            barang_kode: {
                required: "Kode barang harus diisi.",
                maxlength: "Kode barang maksimal 100 karakter.",
                remote: "Kode barang sudah ada."
            },
            barang_nama: {
                required: "Nama barang harus diisi.",
                maxlength: "Nama barang maksimal 255 karakter."
            },
            harga_beli: {
                number: "Harga beli harus berupa angka."
            },
            harga_jual: {
                number: "Harga jual harus berupa angka."
            }
        },
        submitHandler: function(form) {
            // Lakukan AJAX submit jika validasi berhasil
            $.ajax({
                url: form.action,  // URL untuk mengirim data
                type: form.method, // Metode pengiriman (POST)
                data: $(form).serialize(),  // Ambil data dari form
                success: function(response) {
                    if (response.status) {
                        // Menutup modal jika berhasil
                        $('#myModal').modal('hide');
                        
                        // Menampilkan notifikasi sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        
                        // Reload DataTable setelah berhasil
                        dataUser.ajax.reload();
                    } else {
                        // Mengosongkan pesan error sebelumnya
                        $('.error-text').text('');
                        
                        // Menampilkan pesan error pada setiap field yang invalid
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        
                        // Menampilkan pesan error umum
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Menampilkan pesan error jika terjadi masalah saat request AJAX
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Silakan coba lagi'
                    });
                }
            });
            return false;  // Prevent default form submission
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            // Penempatan error message
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            // Menambahkan kelas is-invalid pada element yang error
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            // Menghapus kelas is-invalid saat validasi berhasil
            $(element).removeClass('is-invalid');
        }
    });
});
</script>