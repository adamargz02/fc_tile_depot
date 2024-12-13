<?php
$page_title = 'My Profile';
require_once('includes/load.php');
// Check what level of user has permission to view this page
page_require_level(3);

$user_id = (int)$_GET['id'];
if (empty($user_id)) {
    redirect('home.php', false);
} else {
    $user_p = find_by_id('users', $user_id);
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="panel profile">
            <div class="jumbotron text-center bg-red">
                <img class="img-circle img-size-2" 
                     src="uploads/users/<?php echo !empty($user_p['image']) ? $user_p['image'] : 'default.png'; ?>" 
                     alt="<?php echo $user_p['name']; ?>'s profile picture">
                <h3><?php echo first_character($user_p['name']); ?></h3>
            </div>
            <?php if ($user_p['id'] === $user['id']): ?>
                <ul class="nav nav-pills nav-stacked text-center">
                    <li>
                        <a href="edit_account.php" class="btn btn-primary">
                            <i class="glyphicon glyphicon-edit"></i> Edit Profile
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
