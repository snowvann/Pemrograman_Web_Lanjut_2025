<form id="barangForm">
    <div class="form-group">
        <label for="kategori_id">Kategori ID:</label>
        <input type="number" name="kategori_id" id="kategori_id" class="form-control" value="{{ $barang->kategori_id }}">
    </div>
    <div class="form-group">
        <label for="barang_kode">Kode Barang:</label>
        <input type="text" name="barang_kode" id="barang_kode" class="form-control" value="{{ $barang->barang_kode }}">
    </div>
    <div class="form-group">
        <label for="barang_nama">Nama Barang:</label>
        <input type="text" name="barang_nama" id="barang_nama" class="form-control" value="{{ $barang->barang_nama }}">
    </div>
    <div class="form-group">
        <label for="harga_beli">Harga Beli:</label>
        <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="{{ $barang->harga_beli }}">
    </div>
    <div class="form-group">
        <label for="harga_jual">Harga Jual:</label>
        <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="{{ $barang->harga_jual }}">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
$(document).ready(function() {
    $('#barangForm').validate({
        rules: {
            kategori_id: {
                required: true,
                digits: true
            },
            barang_kode: {
                required: true,
                maxlength: 100,
                remote: {
                    url: "{{ route('barang.check_unique', $barang->barang_id) }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        barang_kode: function() {
                            return $("#barang_kode").val();
                        }
                    }
                }
            },
            barang_nama: {
                required: true,
                maxlength: 255
            },
            harga_beli: {
                number: true
            },
            harga_jual: {
                number: true
            }
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
            $.ajax({
                url: "{{ route('barang.update_ajax', $barang->barang_id) }}",
                type: "PUT",
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        // Tutup modal atau lakukan tindakan lain
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
});
</script>