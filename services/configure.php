
<?php
$connection = mysql_connect('localhost','root','') or die ('Failed To Connect'.mysql_error());

mysql_select_db('main_database',$connection) or die ('Failed To Select Database'.mysql_error());
