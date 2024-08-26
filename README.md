# PHP FFmpeg Script for RTSP Restreaming with Watermark

This repository contains a PHP script that utilizes FFmpeg to combine two RTSP video streams, add an audio track, overlay a watermark, and stream the combined video to an RTMP endpoint, such as Facebook Live. The videos are stacked vertically with proportional scaling to maintain their aspect ratio.

## Features

- **RTSP Stream Input:** Supports two RTSP video sources.
- **Audio Overlay:** Allows for an audio track to be overlaid on the video.
- **Watermark Text:** Adds a custom watermark text to the streamed video.
- **RTMP Output:** Streams the final output to an RTMP server (e.g., Facebook Live).
- **Proportional Video Scaling:** Ensures that both videos are scaled proportionally and stacked vertically.

## Prerequisites

- **FFmpeg:** Make sure FFmpeg is installed on your server.
  - You can install FFmpeg on a Linux server using the following command:
    ```bash
    sudo apt-get update
    sudo apt-get install ffmpeg
    ```

- **PHP:** The script requires PHP to run. Make sure PHP is installed and properly configured on your server.

## Usage

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/iptvpanel/restreaming.git
   cd restreaming
