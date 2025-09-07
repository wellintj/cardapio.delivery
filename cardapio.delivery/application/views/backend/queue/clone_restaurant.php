<div class="row">
    <div class="col-md-8">
        <form action="<?= base_url("admin/queue/clone"); ?>" method="post" id="cloneForm">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-header">
                    <h4><?= lang('clone_a_restaurant'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><?= lang('clone_from_user'); ?> </label>
                        <select name="old_user_id" id="old_user_id" class="form-control select2">
                            <option value=""><?= lang('select'); ?></option>
                            <?php foreach ($userList as  $key => $row) : ?>
                                <option value="<?= $row['id'] ?>"> <?= $row['username']; ?> / <?= $row['email']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= lang('clone_for_user'); ?></label>
                        <select name="new_user_id" id="new_user_id" class="form-control select2">
                            <option value=""><?= lang('select'); ?></option>
                            <?php foreach ($newRestaurant as  $key => $new) : ?>
                                <option value="<?= $new->user_id ?>"> <?= $new->username; ?> / <?= $new->email; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-secondary"><?= lang('submit'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Progress bar HTML -->
<div id="progressBarContainer">
    <div id="progressBar"></div>
    <div id="progressText">Cloning in progress...</div>
</div>


<script>
    $(document).ready(function() {
        // Attach event listener to the form submission
        $('#cloneForm').submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();
            let url = $(this).attr('action');
            // Start the cloning process
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    updateProgress(response.progress, response.totalTasks);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error:', textStatus, errorThrown);
                }
            });
        });

        // Function to update the progress bar
        function updateProgress(progress, totalTasks) {
            var percentage = (progress / totalTasks) * 100;
            $('#progressBar').width(percentage + '%');

            // Check if the cloning is complete
            if (progress >= totalTasks) {
                $('#progressText').text('Cloning complete!');
            }
        }
    });
</script>