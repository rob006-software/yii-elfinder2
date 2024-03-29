<?php

/* @var $settings array */
/* @var $title string */

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?= CHtml::encode($title) ?></title>

		<script type="text/javascript">
			var FileBrowserDialogue = {
				init: function() {
					// Here goes your code for setting your custom things onLoad.
				},
				mySubmit: function(URL) {
					// pass selected file path to TinyMCE
					parent.tinymceImageUploadCallback(URL);

					// close popup window
					parent.tinymce.activeEditor.windowManager.close();
				}
			}

			$().ready(function() {
				var elfSettings = <?= CJSON::encode($settings) ?>;
				elfSettings["getFileCallback"] = function(file) { // editor callback
					FileBrowserDialogue.mySubmit(file.url); // pass selected file path to TinyMCE
				};
				var elf = $('#elfinder').elfinder(elfSettings).elfinder('instance');
			});
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
