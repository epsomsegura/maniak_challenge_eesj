<div class="modal" id="mdlForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmSave" action="{{url('/categories')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Fullname" title="Fullname" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" name="description" maxlength="255" id="description" placeholder="Description" title="Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <input id="saveTrigger" type="submit" hidden >
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>
