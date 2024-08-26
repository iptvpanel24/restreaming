<?php
// Lokasi file FFmpeg
$ffmpeg = '/usr/bin/ffmpeg';

// Sumber video RTSP
$videoSource = 'http://stream.cctv.malangkota.go.id/WebRTCApp/streams/188896189032493229715252.m3u8'; // Tugu malang 

// Sumber audio MP3
$audioSource = '/opt/audioku.mpeg'; // Ganti dengan nama file audio Anda

// Watermark teks
$watermarkText = "Restreaming by : iptvpanel.classy.id"; // Teks watermark yang ingin Anda gunakan

// URL RTMP YouTube Live Anda
$rtmpUrl = 'rtmps://live-api-s.facebook.com:443/rtmp/<ID>'; // Ganti dengan URL RTMP Anda

// Frame rate video (misalnya 30 fps)
$frameRate = 30;

// Interval keyframe (GOP) harus diatur ke 2 detik (untuk frame rate 30 fps, ini berarti GOP = 60)
$keyframeInterval = $frameRate * 2;

// Command FFmpeg
$ffmpegCommand = "$ffmpeg -i $videoSource -stream_loop -1 -i $audioSource -vf \"drawtext=text='$watermarkText':x=50:y=50:fontsize=15:fontcolor=white\" -c:v libx264 -c:a aac -g $keyframeInterval -strict experimental -f flv \"$rtmpUrl\"";

// Loop untuk memastikan FFmpeg dijalankan kembali jika berhenti
while (true) {
    // Menjalankan command FFmpeg
    exec($ffmpegCommand, $output, $returnCode);

    // Output pesan sukses atau error
    if ($returnCode === 0) {
        echo "Streaming telah dimulai!";
        break; // Keluar dari loop jika streaming berjalan dengan sukses
    } else {
        echo "Error saat memulai streaming: " . implode(PHP_EOL, $output);
        echo "Mencoba untuk memulai ulang streaming...\n";
        sleep(5); // Tunggu 5 detik sebelum mencoba ulang
    }
}
?>
