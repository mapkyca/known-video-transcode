<?php

namespace IdnoPlugins\VideoTranscode\Pages {

    class Admin extends \Idno\Common\Page {

	function getContent() {
	    $this->adminGatekeeper(); // Admins only
	    $t = \Idno\Core\site()->template();
	    $body = $t->draw('admin/videotranscode');
	    $t->__(array('title' => 'Video Transcode', 'body' => $body))->drawPage();
	}

	function postContent() {
	    $this->adminGatekeeper(); // Admins only

	    \Idno\Core\Idno::site()->config->config['VideoTranscode'] = [
		'ffmpeg' => $this->getInput('ffmpeg'),
		'faststart' => $this->getInput('faststart'),
		'timeoutbin' => $this->getInput('timeoutbin', '/usr/bin/timeout'),
		'timeout' => (int)$this->getInput('timeout', 600),
	    ];
	    \Idno\Core\Idno::site()->config()->save();
	    \Idno\Core\Idno::site()->session()->addMessage('Video Transcoding settings saved.');

	    $this->forward(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/videotranscode/');
	}

    }

}