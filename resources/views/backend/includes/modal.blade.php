<!-- Large Modal -->
<div class="modal fade" id="largeModal" tabindex="-1" aria-labelledby="largeModal-label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="largeModal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-border text-light m-2" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Small Modal -->
<div class="modal fade" id="smallModal" tabindex="-1" aria-labelledby="smallModal-label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="spinner-border text-light m-2" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModal-label" aria-modal="true" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <form method="POST" class="ajaxDeleteForm" action="" id="delete_form">
                    @csrf
                    @method('DELETE')
                    <i class="fa-solid fa-circle-info" style="font-size: 50px; color: #6c757d;"></i>
                    <p class="mt-3">Are you sure?</p>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulk-delete-modal" tabindex="-1" aria-labelledby="bulk-delete-modal-label" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk-delete-modal-label">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">Are you sure to delete selected items?</p>
                <button type="button" class="btn btn-link mt-2" data-bs-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" onclick="executeBulkDelete()" class="btn btn-primary mt-2">Delete</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bulk Active Modal -->
<div class="modal fade" id="bulk-active-modal" tabindex="-1" aria-labelledby="bulk-active-modal-label" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk-active-modal-label">Activate Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">Are you sure to activate selected items?</p>
                <button type="button" class="btn btn-link mt-2" data-bs-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" onclick="executeBulkActive()" class="btn btn-success mt-2">Activate</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Bulk Inactive Modal -->
<div class="modal fade" id="bulk-inactive-modal" tabindex="-1" aria-labelledby="bulk-inactive-modal-label" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk-inactive-modal-label">Deactivate Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">Are you sure to deactivate selected items?</p>
                <button type="button" class="btn btn-link mt-2" data-bs-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" onclick="executeBulkInactive()" class="btn btn-warning mt-2">Deactivate</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
