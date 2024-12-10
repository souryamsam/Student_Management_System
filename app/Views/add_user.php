<?php
if (!empty($user)) {
    $user_id = $user['id'];
    $coustomer_name = $user['name'];
    $c_person = $user['contact_p'];
    $c_number = $user['number'];
    $email = $user['email'];
    $gender = $user['gender'];
    $country = $user['country'];
    $state = $user['state'];
    $district = $user['city'];
    $p_address = $user['p_address'];
    $c_address = $user['c_address'];
} else {
    $user_id = old('user_id');
    $coustomer_name = old('name');
    $c_person = old('c_person');
    $c_number = old('c_number');
    $email = old('email');
    $gender = old('gender');
    $country = old('country');
    $state = old('state');
    $district = old('city');
    $p_address = old('p_address');
    $c_address = old('c_address');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
        <h2>Add User</h2>
        <a class="btn btn-sm btn-primary" href="<?= base_url('/view') ?>">View User</a>
        <form action="<?= base_url('/save_user'); ?>" method="POST">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Coustomer Name <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $coustomer_name ?>">
                <?php if (session()->get('errors')['name'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['name'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Contact Person <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control" id="c_person" name="c_person" value="<?= $c_person ?>">
                <?php if (session()->get('errors')['c_person'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['c_person'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Contact No <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control c_number" id="c_number" name="c_number" value="<?= $c_number ?>"
                    onkeyup="duplicate_checking(event, this ,'number')">
                <div class="text-danger text-capitalize duplicateMessage"> </div>
                <?php if (session()->get('errors')['c_number'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['c_number'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email ID <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control email" id="email" name="email" value="<?= $email ?>"
                    onkeyup="duplicate_checking(event, this ,'email')">
                <div class="text-danger text-capitalize duplicate_message"> </div>
                <?php if (session()->get('errors')['email'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['email'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender <span class="text-danger text-capitalize">*</span></label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option value="Male" <?= 'Male' == $gender ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= 'Female' == $gender ? 'selected' : '' ?>>Female</option>
                    <option value="Transgender" <?= 'Transgender' == $gender ? 'selected' : '' ?>>Transgender
                    </option>
                </select>
                <?php if (session()->get('errors')['gender'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['gender'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Country <span
                        class="text-danger text-capitalize">*</span></label>
                <select class="form-control" name="country" id="country">
                    <option value="">Select Country</option>
                    <?php
                    if (!empty($county)) {
                        foreach ($county as $c_row) {
                            ?>
                            <option value="<?= $c_row['c_id'] ?>" <?= $c_row['c_id'] == $country ? 'selected' : '' ?>>
                                <?= $c_row['c_name'] ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php if (session()->get('errors')['country'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['country'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">State <span class="text-danger text-capitalize">*</span></label>
                <select class="form-control" name="state" id="state">
                    <option value="">Select State</option>
                </select>
                <?php if (session()->get('errors')['state'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['state'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">City <span class="text-danger text-capitalize">*</span></label>
                <select class="form-control" name="city" id="city">
                    <option value="">Select City</option>
                </select>
                <?php if (session()->get('errors')['city'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['city'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Permanent Address <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control" id="p_address" name="p_address" value="<?= $p_address ?>">
                <?php if (session()->get('errors')['p_address'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['p_address'] ?></span>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Current Address <span
                        class="text-danger text-capitalize">*</span></label>
                <input type="text" class="form-control" id="c_address" name="c_address" value="<?= $c_address ?>">
                <?php if (session()->get('errors')['c_address'] ?? false) { ?>
                    <span style="color:red"><?= session()->get('errors')['c_address'] ?></span>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
<script>
    $(document).ready(function () {
        $('#country').change(function () {
            var country = $(this).val();
            $.ajax({
                url: "<?= base_url('country_id'); ?>",
                type: 'POST',
                data: {
                    country: country
                },
                dataType: 'json',
                success: function (res) {
                    var options = '<option value="">Select State</option>';
                    if (res.status === '1') {
                        var state_code = '<?= $state ?>';
                        $.each(res.data, function (key, value) {
                            var selected = (state_code == value.s_id) ?
                                'selected' : '';
                            options += '<option value="' + value.s_id + '" ' +
                                selected +
                                '>' + value.s_name + '</option>';
                        });
                    }
                    $('#state').html(options);
                    $('#state').trigger('change');
                },
            });
        });
        $('#state').change(function () {
            var state_code = $(this).val();
            $.ajax({
                url: "<?= base_url('state_id'); ?>",
                type: 'POST',
                data: {
                    state_code: state_code
                },
                dataType: 'json',
                success: function (res) {
                    var options = '<option value="">Select City</option>';
                    if (res.status === '1') {
                        var district_code = '<?= $district ?>';
                        $.each(res.data, function (key, value) {
                            var selected = (district_code == value.d_id) ?
                                'selected' : ''
                            options += '<option value="' + value.d_id + '" ' +
                                selected +
                                '>' + value.d_name + '</option>';
                        });
                    }
                    $('#city').html(options);
                },
            });
        });
        <?php
        if ($country) { ?>
            $('#country').trigger('change');
            <?php
        } ?>
    });

    function duplicate_checking(event, input, type) {
        event.preventDefault();
        var inputValue = $(input).val();
        $.ajax({
            url: '<?= base_url('duplicate_check'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                type: type,
                value: inputValue
            },
            success: function (response) {
                if (response.status == 1) {
                    if (type === 'number') {
                        $('.duplicateMessage').html("Duplicate Contact Number found");
                        $('.c_number').val('');
                    } else if (type == 'email') {
                        $('.duplicate_message').html("Duplicate email id found");
                        $('.email').val('');
                    } else {
                        $('.duplicateMessage').html("");
                        $('.duplicate_message').html("")
                    }
                } else {
                    $('.duplicateMessage').html("");
                    $('.duplicate_message').html("");
                }
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    }
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