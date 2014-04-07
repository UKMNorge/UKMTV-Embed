<?xml version="1.0" encoding="UTF-8"?>
<smil title="">
	<body>
		<switch>
			<video height="480" src="<?= str_replace('720p','mobile', $TV->file) ?>" systemLanguage="eng" width="852">
				<param name="videoBitrate" value="890000" valuetype="data"></param>
				<param name="audioBitrate" value="44100" valuetype="data"></param>
			</video>
			<video height="720" src="<?= $TV->file ?>" systemLanguage="eng" width="1272">
				<param name="videoBitrate" value="3000000" valuetype="data"></param>
				<param name="audioBitrate" value="44100" valuetype="data"></param>
			</video>
		</switch>
	</body>
</smil>
