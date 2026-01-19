<?php
$dir = 'recordings/' . date('Y-m-d');
if (!is_dir($dir)) mkdir($dir, 0777, true);

$filename = $dir . '/audio_' . date('H-i-s') . '_part' . ($_POST['part'] ?? 1) . '.webm';
move_uploaded_file($_FILES['audio']['tmp_name'], $filename);
