<?php


echo microtime(true)."<br>";

var_dump(mysqli_connect('127.0.0.1','root','didi2019'));
echo "<br>".microtime(true)."<br>";
var_dump(mysqli_connect('localhost','root','didi2019'));
echo "<br>".microtime(true)."<br>";
