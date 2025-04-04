<form id="supplierForm">
    <div class="form-group">
        <label for="supplier_name">Nama Supplier:</label>
        <input type="text" name="supplier_name" id="supplier_name" class="form-control">
    </div>
    <div class="form-group">
        <label for="supplier_address">Alamat Supplier:</label>
        <textarea name="supplier_address" id="supplier_address" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="supplier_phone">Telepon Supplier:</label>
        <input type="text" name="supplier_phone" id="supplier_phone" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
$(document).ready(function() {
    $('#supplierForm').validate({
        rules: {
            supplier_name: {
                required: true,
                maxlength: 100,
                remote: {
                    url: "{{ route('supplier.check_unique') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        supplier_name: function() {
                            return $("#supplier_name").val();
                        }
                    }
                }
            },
            supplier_phone: {
                maxlength: 20
            }
        },
        messages: {
            supplier_name: {
                required: "Nama supplier harus diisi.",
                maxlength: "Nama supplier maksimal 100 karakter.",
                remote: "Nama supplier sudah ada."
            },
            supplier_phone: {
                maxlength: "Telepon supplier maksimal 20 karakter."
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: "{{ route('supplier.store_ajax') }}",
                type: "POST",
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