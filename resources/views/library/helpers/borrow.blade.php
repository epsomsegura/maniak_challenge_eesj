<div class="modal" id="mdlBorrow" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrow book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="frmSave" action="{{url('library')}}" method="POST">
            @csrf
            <input type="hidden" name="book_id" id="book_id" required>
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <div class="form-group">
                            <strong id="bookName"></strong>
                        </div>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label for="user_id" class="form-label">To reader:</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="" disabled selected>Select reader</option>
                            @foreach($users as $u)
                            <option value="{{$u->id}}">{{$u->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <input type="submit" hidden id="saveTrigger">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave">Borrow book</button>
      </div>
    </div>
  </div>
</div>
