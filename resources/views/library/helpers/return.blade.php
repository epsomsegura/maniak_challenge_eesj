<div class="modal" id="mdlReturn" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmReturn" action="{{url('library')}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="library_id" id="library_id" required>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <strong id="bookName"></strong>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                Reader: <strong id="readerName"></strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                Borrowed date: <strong id="borrowedDate"></strong>
                            </div>
                        </div>
                    </div>
                    <input type="submit" hidden id="saveTriggerR">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnReturn">Return book</button>
            </div>
        </div>
    </div>
</div>
