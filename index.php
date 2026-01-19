<!DOCTYPE html>
<html>
<head>
  <title>Voice Recorder</title>
  <style>
    body { font-family: Arial; text-align:center; }
    button { padding:15px 30px; font-size:16px; margin:10px; }
    .start { background:#4a73c9; color:white; border:none; }
    .stop { background:red; color:white; border:none; }
    table { width:80%; margin:30px auto; border-collapse:collapse; }
    th, td { padding:10px; border:1px solid #ccc; }
    th { background:#4a73c9; color:white; }
    tr:nth-child(even) { background:#eef2fb; }
  </style>
</head>
<body>

<button class="start" onclick="startRecord()">START RECORD</button>
<button class="stop" onclick="stopRecord()">STOP RECORD</button>

<table>
  <thead>
    <tr>
      <th>Date – Time Recording</th>
      <th>Name Recording</th>
      <th>Button Play</th>
    </tr>
  </thead>
  <tbody id="recordList"></tbody>
</table>

<script>
let recorder, stream, part = 1;

async function startRecord() {
  stream = await navigator.mediaDevices.getUserMedia({ audio: true });

  recorder = new MediaRecorder(stream, {
    mimeType: 'audio/webm;codecs=opus',
    audioBitsPerSecond: 32000
  });

  recorder.ondataavailable = async e => {
    if (e.data.size === 0) return;

    let fd = new FormData();
    fd.append('audio', e.data, `part_${part}.webm`);
    fd.append('part', part);

    await fetch('upload.php', { method:'POST', body:fd });
    loadList();
    part++;
  };

  recorder.start(30 * 60 * 1000); // 30 menit
}

function stopRecord() {
  recorder.stop();
  stream.getTracks().forEach(t => t.stop());
}

async function loadList() {
  const res = await fetch('list.php');
  document.getElementById('recordList').innerHTML = await res.text();
}

loadList();
</script>

</body>
</html>
