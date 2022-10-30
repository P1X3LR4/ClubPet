
<?php

if (isset($_SESSION['message'])) {
  if (strpos($_SESSION['message'], 'sucesso')) {
    $color = 'success';
  } else if (strpos($_SESSION['message'], 'incorreto')) {
    $color = 'warning';
  } else if (strpos($_SESSION['message'], 'já está cadastrado')) {
    $color = 'primary';
  } else {
    $color = 'danger';
  }
  echo '<div class="toast align-items-center text-bg-' . $color . ' border-0" role="alert" style="position: absolute; top: 90%; right: 20px; z-index: 10;" id="myToastMessage">
    <div class="d-flex">
      <div class="toast-body">
       ' . $_SESSION['message'] . '
       </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>';
}
unset($_SESSION['message']);


?>