<form id="levelForm">
    <div class="form-group">
        <label for="level_name">Nama Level:</label>
        <input type="text" name="level_name" id="level_name" class="form-control" value="{{ $level->level_name }}">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
$(document).ready(function() {
    $('#levelForm').validate({
        rules: {
            level_name: {
                required: true,
                maxlength: 100,
                remote: {
                    url: "{{ route('level.check_unique', $level->level_id) }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        level_name: function() {
                            return $("#level_name").val();
                        }
                    }
                }
            }
        },
        messages: {
            level_name: {
                required: "Nama level harus diisi.",
                maxlength: "Nama level maksimal 100 karakter.",
                remote: "Nama level sudah ada."
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: "{{ route('level.update_ajax', $level->level_id) }}",
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