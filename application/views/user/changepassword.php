<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- /.container-fluid -->
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
            <form class="user" method="post" action="<?= base_url('user/changepassword'); ?>">
                <div class="form-group row">
                    <label for="currentpassword" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="currentpassword" name="currentpassword">
                        <?= form_error('currentpassword', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="newpassword1" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="newpassword1" name="newpassword1">
                        <?= form_error('newpassword1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="newpassword2" class="col-sm-2 col-form-label">Repeat Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="newpassword2" name="newpassword2">
                        <?= form_error('newpassword2', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group justify-content-end">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div> <!-- End of Main Content -->