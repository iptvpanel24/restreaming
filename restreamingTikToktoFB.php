<?php
// Lokasi file FFmpeg
$ffmpeg = '/usr/bin/ffmpeg';

// Sumber video (URL TikTok)
$videoSource = '<url live tiktok>'; // Ganti dengan URL video Anda

// URL RTMP tujuan (Facebook Live)
$rtmpUrl = '<url rtmp facebook>'; // Ganti dengan URL RTMP Anda

// Pengaturan video
$videoCodec = 'libx264';
$videoProfile = 'baseline';
$videoBitrate = '2500K';
$resolution = '720x1280';
$frameRate = 30; // Set frame rate ke 30 fps
$keyFrameRate = 60; // Set key frame rate ke 60 (1 key frame per 2 detik)

// Pengaturan audio
$audioCodec = 'aac';
$audioChannels = 1;
$audioBitrate = '56k';

// Pengaturan teks watermark
$fontSizeSmall = 24;
$fontSizeLarge = 48;
$fontColor = 'white';
$boxColor = 'black@0.5';
$watermarkText = '@helmkediri';

// Command FFmpeg
$ffmpegCommand = "$ffmpeg -i \"$videoSource\" -threads 1 -c:v $videoCodec -profile:v $videoProfile -b:v $videoBitrate -s $resolution -r $frameRate -g $keyFrameRate -f flv -c:a $audioCodec -ac $audioChannels -strict -2 -b:a $audioBitrate";
$ffmpegCommand .= " -vf \"drawtext=text='%{localtime\\: %d-%m-%Y}':x=w-tw-10:y=10:fontsize=$fontSizeSmall:fontcolor=$fontColor:box=1:boxcolor=$boxColor,";
$ffmpegCommand .= "drawtext=text='%{localtime\\: %T}':x=w-tw-10:y=40:fontsize=$fontSizeSmall:fontcolor=$fontColor:box=1:boxcolor=$boxColor,";
$ffmpegCommand .= "drawtext=text='$watermarkText':x=(w-text_w)/2:y=(h-text_h)/2:fontsize=$fontSizeLarge:fontcolor=orange:box=1:boxcolor=$boxColor\" \"$rtmpUrl\"";

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
