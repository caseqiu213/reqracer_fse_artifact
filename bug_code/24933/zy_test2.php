<?php
require( dirname(__FILE__) . '/wp-blog-header.php');

// $update1 = update_metadata( 'post', 1, '_test', 'value1');

$update2 = update_metadata( 'post', 1, '_test', 'value2', 'value1');

// $update3 = update_metadata( 'post', 1, '_test', 'value3', 'value1');


// echo "1: " . $update1 . "<br>";
// echo "2: " . $update2 . "<br>";
// echo "3: " . $update3 . "<br>";

echo 'Done.';

?>