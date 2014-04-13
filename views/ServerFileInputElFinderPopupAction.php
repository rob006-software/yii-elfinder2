<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>

		<script type="text/javascript">
			var FileBrowserDialogue = {
				init: function() {
					// Here goes your code for setting your custom things onLoad.
				},
				mySubmit: function(URL) {
					self.parent.document.getElementById('<?php echo $fieldId; ?>').value = URL;
					self.parent.$('#<?php echo $fieldId; ?>-dialog').dialog('close');
				}
			}

			$().ready(function() {
				var elfSettings = <?php echo $settings; ?>;
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