404 not found
<br>
<?php if (file_exists('debug')) : ?>
Error: <br>
<?php
echo 'line:'. $e->getLine()."<br>";
echo 'File:'. $e->getFile() . "<br>";
echo $e->getMessage();

endif;