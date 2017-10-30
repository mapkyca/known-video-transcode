

<div class="row">

    <div class="col-md-10 col-md-offset-1">
	<?= $this->draw('admin/menu') ?>
        <h1>Video Transcoding settings</h1>
    </div>

</div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?= \Idno\Core\site()->config()->getURL() ?>admin/videotranscode/" class="form-horizontal" method="post">





	    <div class="row">
		<div class="col-md-2 col-md-offset-1">
		    <label class="control-label" for="ffmpeg">FFMPeg Location<br>

		    </label>
		</div>
		<div class="col-md-8">
		    <?=
			    $this
			    ->__(['name' => 'ffmpeg',
				'value' => (!empty(\Idno\Core\Idno::site()->config()->VideoTranscode['ffmpeg'])) ? \Idno\Core\Idno::site()->config()->VideoTranscode['ffmpeg'] : '',
				'placeholder' => '/usr/bin/ffmpeg',
				'class' => 'form-control'])
			    ->draw('forms/input/text');
		    ?>
		    <p class="config-desc">Absolute path to ffmpeg binary.</p>
		</div>
	    </div>

	    <div class="row">
		<div class="col-md-2 col-md-offset-1">
		    <label class="control-label" for="faststart">QT Faststart<br>

		    </label>
		</div>
		<div class="col-md-8">
		    <?=
			    $this
			    ->__(['name' => 'faststart',
				'value' => (!empty(\Idno\Core\Idno::site()->config()->VideoTranscode['faststart'])) ? \Idno\Core\Idno::site()->config()->VideoTranscode['faststart'] : '',
				'placeholder' => '/usr/bin/qt-faststart',
				'class' => 'form-control'])
			    ->draw('forms/input/text');
		    ?>
		    <p class="config-desc">Absolute path to qt-faststart binary.</p>
		</div>
	    </div>
	    
	    <div class="row">
		<div class="col-md-2 col-md-offset-1">
		    <label class="control-label" for="faststart">Timeout Bin<br>

		    </label>
		</div>
		<div class="col-md-8">
		    <?=
			    $this
			    ->__(['name' => 'timeoutbin',
				'value' => (!empty(\Idno\Core\Idno::site()->config()->VideoTranscode['timeoutbin'])) ? \Idno\Core\Idno::site()->config()->VideoTranscode['timeoutbin'] : '',
				'placeholder' => '/usr/bin/timeout',
				'class' => 'form-control'])
			    ->draw('forms/input/text');
		    ?>
		    <p class="config-desc">Absolute path to the timeout binary.</p>
		</div>
	    </div>
	    
	    <div class="row">
		<div class="col-md-2 col-md-offset-1">
		    <label class="control-label" for="faststart">Timeout<br>

		    </label>
		</div>
		<div class="col-md-8">
		    <?=
			    $this
			    ->__(['name' => 'timeout',
				'value' => (!empty(\Idno\Core\Idno::site()->config()->VideoTranscode['timeout'])) ? \Idno\Core\Idno::site()->config()->VideoTranscode['timeout'] : '',
				'placeholder' => '600',
				'class' => 'form-control'])
			    ->draw('forms/input/text');
		    ?>
		    <p class="config-desc">The maximum time in seconds ffmpeg can execute before it's forcibly terminated. Use 0 to execute forever (not recommended as some files can cause ffmpeg to hang).</p>
		</div>
	    </div>


	    <div class="row">
		<div class="controls-group">
		    <div class="controls-save">
			<button type="submit" class="btn btn-primary">Save</button>
		    </div>
		</div>
	    </div>
<?= \Idno\Core\site()->actions()->signForm('/admin/videotranscode/') ?>
        </form>

    </div>


</div>