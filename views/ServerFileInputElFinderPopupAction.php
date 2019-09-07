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
					self.parent.$('#<?= $fieldId ?>').val(URL).change();
					self.parent.$('#<?= $fieldId ?>-dialog').dialog('close');
				}
			}

			$().ready(function() {
				var elfSettings = <?= CJSON::encode($settings) ?>;
				elfSettings["getFileCallback"] = function(file) { // editor callback
					FileBrowserDialogue.mySubmit(file.url); // pass selected file path to field
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
