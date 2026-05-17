<form id="change-password" action="{{ route('companies.change-password.update', $pageData->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Password -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Enter new password" required minlength="8">
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="col-sm-12">
            <div class="form-group mb-2">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required minlength="8">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="col-sm-12">
            <div class="text-center mt-1">
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    initValidate('#change-password');
    
    $("#change-password").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, callbackChangePasswordForm);
    });

    const callbackChangePasswordForm = function(response) {
        setTimeout(function() {
            location.reload();
        }, 1500);
    }
});
</script>