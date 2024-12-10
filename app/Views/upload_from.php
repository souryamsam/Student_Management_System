<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <a class="btn btn-sm btn-primary" href="<?= base_url('/view'); ?>">View User</a>
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h3>Submit Your Details</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('upload-from'); ?>" method="POST" enctype="multipart/form-data">
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                            value="<?= old('name'); ?>">
                        <?php if (session()->get('errors')['name'] ?? false) { ?>
                            <span style="color:red"><?= session()->get('errors')['name'] ?></span>
                        <?php } ?>
                    </div>

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"
                            placeholder="Enter your address"><?= old('address'); ?></textarea>
                        <?php if (session()->get('errors')['address'] ?? false) { ?>
                            <span style="color:red"><?= session()->get('errors')['address'] ?></span>
                        <?php } ?>
                    </div>

                    <!-- Photo Upload Field -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Upload Photo</label>
                        <input type="file" class="form-control" id="photo" name="upload" accept="">
                        <?php if (session()->get('errors')['upload'] ?? false) { ?>
                            <span style="color:red"><?= session()->get('errors')['upload'] ?></span>
                        <?php } ?>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
<script>
    <?php if (session()->getFlashdata('msg')) {
        $msg = session()->getFlashdata('msg');
        if ($msg["status"] == 1) {
            ?>
            $.toast({
                heading: "Success!",
                text: "<?= $msg['message'] ?>",
                showHideTransition: "fade",
                position: "top-right",
                icon: "success",
                loader: true,
                hideAfter: 3000
            });
        <?php } else { ?>
            $.toast({
                heading: "Warning",
                text: "<?= $msg['message'] ?>",
                showHideTransition: "fade",
                position: "top-right",
                icon: "error",
                loader: true,
                hideAfter: 3000
            });
        <?php } ?>
    <?php } ?>
</script>