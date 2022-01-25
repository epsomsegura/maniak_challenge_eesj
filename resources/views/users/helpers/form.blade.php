<div class="modal" id="mdlForm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmSave" action="{{url('users')}}" method="POST">
                    @csrf
                    <input type="hidden" id="status" name="status" value="1">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label for="name" class="form-label">Fullname:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Fullname" title="Fullname" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" title="Email" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="profile_id" class="form-label">Profile:</label>
                                <select name="profile_id" id="profile_id" class="form-select" title="Profile">
                                    <option value="" disabled selected>Select profile</option>
                                    @foreach($profiles as $p)
                                    <option value="{{$p->id}}">{{$p->profile}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row" id="chngPasswordContainer">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="chngPassword" class="form-label">Change password</label>
                                        <input type="checkbox" id="chngPassword" name="chngPassword">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="passwordContainer">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" title="Password">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="repeat_password" class="form-label">Repeat password:</label>
                                        <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Repeat password" title="Repeat password">
                                    </div>
                                </div>
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
