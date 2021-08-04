<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="text-center" id="myForm" action="department.php" autocomplete="off" method="POST">
                    <div class="mb-2">
                        <input name="oldpass" id="oldpass" type="password" class="form-control" placeholder="Enter The Old Password">
                    </div>
                    <div class="mb-2">
                        <input name="pass" id="pass" type="password" class="form-control" placeholder="Enter The Password">
                    </div>
                    <div class="mb-1"><span id="available"></span></div>
                    <div class="hide"><button id="submit" class="btn btn-primary">Change</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
