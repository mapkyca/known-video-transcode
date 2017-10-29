<?php

namespace IdnoPlugins\VideoTranscode {

    class Main extends \Idno\Common\Plugin {

	function init() {
	    loader()->registerNamespace('Html5Video', dirname(__FILE__) . '/vendor/html5-video-php/src/');
	    parent::init();
	}

	function registerEventHooks() {


	    \Idno\Core\Idno::site()->addEventHook('video/transcode', function (\Idno\Core\Event $event) {
		$eventdata = $event->data();

		\Idno\Core\Idno::site()->logging()->info("Transcoding videos attached to entity: {$eventdata['uuid']}");

		$ia = \Idno\Core\Idno::site()->db()->setIgnoreAccess();
		try {
		    if ($object = \Idno\Common\Entity::getByUUID($eventdata['uuid'])) {
			
			set_time_limit(0);

			$tmp = \Idno\Core\Idno::site()->config()->getTempDir();
			$settings = [
			    'ffmpeg.bin' => \Idno\Core\Idno::site()->config()->VideoTranscode['ffmpeg'],
			    'qt-faststart.bin' => \Idno\Core\Idno::site()->config()->VideoTranscode['faststart'],
			    
			];
			
			$transcoder = new \Html5Video\Html5Video($settings);
			
			if ($attachments = $object->getAttachments()) {
			    foreach($attachments as $attachment) {
				
				// Save video to master tmp
				$masterfile = tempnam($tmp, 'known-transcode-master');
				$file = \Idno\Entities\File::getByID($attachment['_id']);
				chmod($masterfile, 0755);  // Change mode so ffmpeg can access
				
				file_put_contents($masterfile, $file->getBytes());
				
				// Get info
				$info = $transcoder->getVideoInfo($masterfile);
				\Idno\Core\Idno::site()->logging()->debug("Master file details: \n" . var_export($info, true));
				
				// Produce a number of compatible formats
				foreach ([
				    'video/mp4',
				    'video/webm',
				    'video/ogg'
				] as $mime) {
				    
				    // Produce a number of compatible sizes (profiles)
				    foreach ([
					'1080p-hd',
					//'1080p-sd',
					'720p-hd',  
					//'720p-sd', 
					//'480p-hd',
					'480p-sd',
					//'360p-hd',
					//'360p-sd',
					//'240p-hd',
					'240p-sd'
				    ] as $profile) {
					
					$ext = str_replace('video/', '', $mime);
					$outfile = tempnam($tmp, 'known-transcode-encode'); $outfile .= ".$ext";
					touch($outfile);
					chmod($outfile, 0777);  // Change mode so ffmpeg can access
					
					\Idno\Core\Idno::site()->logging()->info("Generating $mime ($profile)...");
					
					try {
					    $transcoder->convert($masterfile, $outfile, $profile,[
						'audio' => true,
						'targetFormat' => $ext
					    ]);
					
					    if ($media = \Idno\Entities\File::createFromFile($outfile, "KTV-{$attachment['_id']}-$profile.$ext", $mime, true)) {
						$object->attachFile($media);
					    } else {
						\Idno\Core\Idno::site()->logging()->error('Transcoded media wasn\'t attached.');
					    }
					} catch (\Exception $e) {
					    \Idno\Core\Idno::site()->logging()->error("Transcode Error: " . $e->getMessage());
					}
					
					unlink($outfile);
				    }
				    
				}
				
				\Idno\Core\Idno::site()->logging()->info("Updating object");
				$object->save();
				unlink($masterfile);
				
			    }
			}
		    }
		} catch (\Exception $e) {
		    \Idno\Core\Idno::site()->logging()->error($e->getMessage());
		}

		$ia = \Idno\Core\Idno::site()->db()->setIgnoreAccess($ia);
	    });
	}

	function registerPages() {

	    \Idno\Core\Idno::site()->addPageHandler('/admin/videotranscode/?', 'IdnoPlugins\VideoTranscode\Pages\Admin');

	    \Idno\Core\Idno::site()->template()->extendTemplate('admin/menu/items', 'admin/videotranscode/menu');
	}

    }

}