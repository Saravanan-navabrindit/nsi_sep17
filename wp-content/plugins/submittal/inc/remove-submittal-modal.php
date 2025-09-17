<div class="row">
    <div class="col-4"></div>
    <div class="col">
        <div
            class="modal fade h-auto position-absolute"
            id="remove-submittal-modal"
            tabindex="-1" role="dialog" aria-labelledby="remove-submittal-modal-label"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="remove-submittal-modal-label"
                        >
                            Are you sure?
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            This Submittal will be deleted and will not be available any more.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary" data-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            id="remove-submittal"
                            type="button"
                            class="btn btn-primary"
                        >
                            Delete
                        </button>
                    </div>
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div><!-- .modal -->
    </div><!-- .col -->
</div><!-- .row -->