<?php
require_once 'inc/bootstrap.php';

$pageTitle = "Time Tracker";
$page = null;

include 'inc/header.php';
?>
    <div class="col-container actions-container">
      <h1>Welcome 
        <?php 
          global $session; 
          $user = findUserById($session->get('auth_user_id'));
          echo $user['username'] . " !";
        ?>
      </h1>
      <p class="actions-copy">What would you like to do today?</p>
      <div class="actions-wrapper">
        <ul class="actions">
          <?php if(isAuth()):?>
              <li class="actions-item">
                  <a class="actions-link" href="task_list.php">
                <span class="actions-icon">
                  <svg viewbox="0 0 64 64"><use xlink:href="#report_icon"></use></svg>
                </span>
                      View Tasks
                  </a>
              </li>
            <li class="actions-item">
              <a class="actions-link" href="task.php">
                <span class="actions-icon">
                  <svg viewbox="0 0 64 64"><use xlink:href="#task_icon"></use></svg>
                </span>
                Add Task
              </a>
            </li>
          <?php else:?>
          <li class="actions-item">
            <a class="actions-link" href="register.php">
              <span class="actions-icon">
                <svg viewbox="0 0 64 64"><use xlink:href="#user_icon"></use></svg>
              </span>
                Register
          <?php endif;?>
		</div>

<?php include("inc/footer.php"); ?>
