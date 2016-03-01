<?php

$file = "http://.../sunshaohaishenA.mp4";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header("Content-Length: " . filesize($file));
readfile($file);
