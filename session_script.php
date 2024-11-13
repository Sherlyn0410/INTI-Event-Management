<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<script>
    // Pass the PHP session variable to JavaScript
    const userName = '<?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : ""; ?>';
</script>