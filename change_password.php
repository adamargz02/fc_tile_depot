<?php
  $page_title = 'Change Password';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if (isset($_POST['update'])) {
    $req_fields = array('new-password', 'old-password', 'id');
    validate_fields($req_fields);

    if (empty($errors)) {
      if (sha1($_POST['old-password']) !== current_user()['password']) {
        $session->msg('d', "Your old password does not match");
        redirect('change_password.php', false);
      }

      $id = (int)$_POST['id'];
      $new = remove_junk($db->escape(sha1($_POST['new-password'])));
      $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
      $result = $db->query($sql);

      if ($result && $db->affected_rows() === 1) {
        $session->logout();
        $session->msg('s', "Login with your new password.");
        redirect('index.php', false);
      } else {
        $session->msg('d', 'Sorry, failed to update!');
        redirect('change_password.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('change_password.php', false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span>Change Password</span>
      </strong>
    </div>
    <div class="panel-body">
      <?php echo display_msg($msg); ?>
      <div class="col-md-6">
        <form method="post" action="change_password.php">
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" name="new-password" placeholder="New password">
          </div>
          <div class="form-group">
            <label for="oldPassword">Old Password</label>
            <input type="password" class="form-control" name="old-password" placeholder="Old password">
          </div>
          <div class="form-group text-right">
            <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
            <button type="submit" name="update" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
