<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
</head>

<body>
    <form id="custom_form" method="post">
        <input type="hidden" name="custom_id" id="custom_id">
        <input type="hidden" name="mode" id="mode">
        <input type="hidden" name="ext_flag" id="ext_flag">
        <input type="hidden" name="ci_csrf_token" value="">
    </form>
    <div class="container mt-5">
        <a class="btn btn-sm btn-danger" href="<?= base_url('logout'); ?>" style="float: right;">Logout</a>
        <h2>Your User ID <?= $session_data['user_id']; ?></h2>
        <a class="btn btn-sm btn-primary" href="<?= base_url('/add'); ?>">Add user</a>
        <a class="btn btn-sm btn-danger" href="<?= base_url('upload'); ?>" style="float: right;">Uploads Photo</a>
        <table class="table">
            <thead>
                <tr>
                    <th>SL. No</th>
                    <th>Coustomer Name</th>
                    <th>Contact Person</th>
                    <th>Contact No</th>
                    <th>Email ID</th>
                    <th>Gender</th>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>City Name</th>
                    <th>Current Address</th>
                    <th>Permanent Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($user)) {
                    $i = 1;
                    foreach ($user as $row) {
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['contact_p']; ?></td>
                            <td><?= $row['number']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['gender']; ?></td>
                            <td><?= $row['country_name']; ?></td>
                            <td><?= $row['state_name']; ?></td>
                            <td><?= $row['district_name']; ?></td>
                            <td><?= $row['c_address']; ?></td>
                            <td><?= $row['p_address']; ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" onclick="editMode('<?= $row['id'] ?>')">Edit</a>
                                <a onclick="update_status('<?= $row['id'] ?>')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<script>
    function editMode(id) {
        document.getElementById('custom_id').value = id;
        document.getElementById('mode').value = 'edit_user_data';
        document.getElementById('custom_form').action = "<?= base_url('add') ?>";
        document.getElementById('custom_form').submit();
    }

    function update_status(id) {
        if (confirm('Are you sure you want to delete the data?')) {
            document.getElementById('custom_id').value = id;
            document.getElementById('custom_form').action = "<?= base_url('status') ?>";
            document.getElementById('custom_form').submit();
        }
    }

    <?php if (session()->getFlashdata('msg')) {
        $msg = session()->getFlashdata('msg');
        if ($msg["status"] == 1) {
            ?>
            $.toast({
                heading: "Success",
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