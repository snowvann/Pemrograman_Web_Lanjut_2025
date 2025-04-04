<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier Ajax</h5>
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

<script>
function modalAction(url) {
    console.log("Loading URL:", url);
    $('#myModal').load(url, function() {
        console.log("Modal loaded");
        $('#myModal').modal('show');
        
        
        $(document).ready(function() {
    $('#supplierForm').validate({
        rules: {
            supplier_kode: {
                required: true,
                maxlength: 10,
                remote: {
                    url: "{{ route('supplier.check_unique') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        supplier_kode: function() {
                            return $("#supplier_kode").val();
                        },
                        id: function() {
                            return $('#simpanSupplier').attr('data-id'); // Tambahkan id jika diperlukan
                        }
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
            $.ajax({
                url: "{{ route('supplier.store_ajax') }}",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $('#myModal').modal('hide'); // Tutup modal
                        $('#supplierTable').DataTable().ajax.reload(); // Reload DataTable
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
    });
}

</script>