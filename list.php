<?php
$base = 'recordings';
$rows = [];

foreach (glob("$base/*/*.webm") as $file) {
  $rows[] = [
    'time' => date("Y-m-d H:i:s", filemtime($file)),
    'name' => basename($file),
    'path' => $file
  ];
}

foreach (array_reverse($rows) as $r) {
  echo "<tr>
    <td>{$r['time']}</td>
    <td>{$r['name']}</td>
    <td>
      <audio controls src='{$r['path']}'></audio>
    </td>
  </tr>";
}
