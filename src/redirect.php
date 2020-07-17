<?php 
ob_start();
?>

<div class="redirection">
    <div class=confirmation><?=$msg?></div>
    <div class=redirect>redirecting...</div>
    <div class="progress" style="opacity : 1">
      <div class="indeterminate"></div>
    </div>
</div>
<script src="public/js/redirect.js"></script>

<?php 
    $content = ob_get_clean();
?>