Known Transcode
===============

Provide video transcoding support for the audio (nee media) plugin, which still supports video... if only sortof.

This plugin uses ffmpeg to generate a number of video files that will play back online.

Installation
------------
* Drop VideoTranscode into your IdnoPlugins directory and activate
* Install ffmpeg ```sudo apt-get install ffmpeg x264```
* Configure the location of ffmpeg and qt-faststart

Now, when you upload a video, it will be queued and transcoded.


Includes
--------

* html5-video-php <https://github.com/xemle/html5-video-php> by Xemle <https://github.com/xemle> distributed under the MIT Licence.

See
---

* Author: Marcus Povey http://www.marcus-povey.co.uk
