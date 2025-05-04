<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-circle"></i> Confirm Review Action
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage">Are you sure you want to <span id="actionText"></span> this review?</p>
            </div>
            <div class="modal-footer">
                <form id="actionForm" method="POST">
                    @csrf
                    @method('post')
                    <input type="hidden" name="action_type" id="modalActionType" value="">
                    <input type="hidden" name="review_id" id="modalReviewId" value="">

                    <button type="submit" class="btn btn-primary">
                        <span><i class="bi bi-check-lg"></i></span>
                        <span id="buttonText">Confirm</span>
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
