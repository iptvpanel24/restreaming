<?php
// Lokasi file FFmpeg
$ffmpeg = '/usr/bin/ffmpeg';

// Sumber video RTSP 1
$videoSource1 = 'http://stream.cctv.malangkota.go.id/12071430581878807503129.m3u8'; // Ganti dengan URL RTSP video pertama Anda

// Sumber video RTSP 2
$videoSource2 = 'http://stream.cctv.malangkota.go.id/621626709539809832237018.m3u8'; // Ganti dengan URL RTSP video kedua Anda

// Sumber audio MP3
$audioSource = '/opt/mp3/doraemon.mp3'; // Ganti dengan nama file audio Anda

// Watermark teks
$watermarkText = "Restreaming by : iptvpanel.classy.id"; // Teks watermark yang ingin Anda gunakan

// URL RTMP Facebook Live Anda
$rtmpUrl = 'rtmps://live-api-s.facebook.com:443/rtmp/FB-3233685210183479-0-Abx6_BEN9o-xFbIo'; // Ganti dengan URL RTMP Anda

// Frame rate video (misalnya 30 fps)
$frameRate = 30;

// Interval keyframe (GOP) harus diatur ke 2 detik (untuk frame rate 30 fps, ini berarti GOP = 60)
$keyframeInterval = $frameRate * 2;

// Bitrate Video
$videoBitrate = "2500k"; // Ganti dengan bitrate yang sesuai (lebih tinggi lebih baik kualitasnya)

// Command FFmpeg
$ffmpegCommand = "$ffmpeg -i $videoSource1 -i $videoSource2 -stream_loop -1 -i $audioSource -filter_complex ";
$ffmpegCommand .= "\"[0:v]scale=iw:-2[v0]; [1:v]scale=iw:-2[v1]; ";
$ffmpegCommand .= "[v0][v1]vstack=inputs=2[v]; ";
$ffmpegCommand .= "[v]drawtext=text='$watermarkText':x=(w-text_w)/2:y=(h-text_h)-10:fontsize=15:fontcolor=white\" ";
$ffmpegCommand .= "-c:v libx264 -b:v $videoBitrate -c:a aac -g $keyframeInterval -strict experimental -f flv \"$rtmpUrl\"";

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
