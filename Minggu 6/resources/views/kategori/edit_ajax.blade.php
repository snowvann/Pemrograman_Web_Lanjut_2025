<form id="kategoriForm">
    <div class="form-group">
        <label for="kategori_name">Nama Kategori:</label>
        <input type="text" name="kategori_name" id="kategori_name" class="form-control" value="{{ $kategori->kategori_name }}">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
$(document).ready(function() {
    $('#kategoriForm').validate({
        rules: {
            kategori_name: {
                required: true,
                maxlength: 100,
                remote: {
                    url: "{{ route('kategori.check_unique', $kategori->kategori_id) }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kategori_name: function() {
                            return $("#kategori_name").val();
                        }
                    }
                }
            }
        },
        messages: {
            kategori_name: {
                required: "Nama kategori harus diisi.",
                maxlength: "Nama kategori maksimal 100 karakter.",
                remote: "Nama kategori sudah ada."
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: "{{ route('kategori.update_ajax', $kategori->kategori_id) }}",
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