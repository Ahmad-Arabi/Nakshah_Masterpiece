<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-circle"></i> Resolve Message
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage">Are you sure you want to change the status of this message to resolved?</p>
            </div>
            <div class="modal-footer">
                <form id="actionForm" method="POST">
                    @csrf
                    @method('put')
                    <input type="hidden" name="status" id="modalActionType" value="resolved">
                    <input type="hidden" name="message_id" id="modalMessageId" value="">

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
