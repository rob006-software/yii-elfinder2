<?php

/**
 * Helper class for elFinder widgets
 *
 * @author Robert Korulczyk <robert@korulczyk.pl>
 * @link http://rob006.net/
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
class ElFinderHelper extends CComponent {

	/**
	 * Available elFinder translations.
	 * @see directory: vendor/assets/js/i18n
	 * @var array
	 */
	public static $availableLanguages = array(
		'ar',
		'bg',
		'ca',
		'cs',
		'da',
		'de',
		'el',
		'es',
		'fa',
		'fo',
		'fr',
		'he',
		'hu',
		'id',
		'it',
		'jp',
		'ko',
		'nl',
		'no',
		'pl',
		'pt_BR',
		'ro',
		'ru',
		'sk',
		'sl',
		'sr',
		'sv',
		'tr',
		'uk',
		'vi',
		'zh_CN',
		'zh_TW',
	);

	/**
	 * @var string
	 */
	private static $_assetsDir;

	/**
	 * Register necessary elFinder scripts and styles.
	 */
	public static function registerAssets() {
		$assetsDir = self::getAssetsDir();
		$cs = Yii::app()->getClientScript();

		// jQuery and jQuery UI
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerCssFile($cs->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');

		// elFinder CSS
		if (YII_DEBUG) {
			$cs->registerCssFile($assetsDir . '/css/elfinder.full.css');
		} else {
			$cs->registerCssFile($assetsDir . '/css/elfinder.min.css');
		}

		// elFinder JS
		if (YII_DEBUG) {
			$cs->registerScriptFile($assetsDir . '/js/elfinder.full.js');
		} else {
			$cs->registerScriptFile($assetsDir . '/js/elfinder.min.js');
		}

		// elFinder translation
		$lang = Yii::app()->language;
		if (!in_array($lang, self::$availableLanguages)) {
			if (strpos($lang, '_')) {
				$lang = substr($lang, 0, strpos($lang, '_'));
				if (!in_array($lang, self::$availableLanguages)) {
					$lang = false;
				}
			} else {
				$lang = false;
			}
		}
		if ($lang !== false) {
			$cs->registerScriptFile($assetsDir . '/js/i18n/elfinder.' . $lang . '.js');
		}

		// some css fixes
		Yii::app()->clientScript->registerCss('elfinder-file-bg-fixer', '.elfinder-cwd-file,.elfinder-cwd-file .elfinder-cwd-file-wrapper,.elfinder-cwd-file .elfinder-cwd-filename{background-image:none !important;}');
	}

	/**
	 * Register default elFinder aliases if needed.
	 */
	public static function registerAlias() {
		if (!Yii::getPathOfAlias('elFinder')) {
			Yii::setPathOfAlias('elFinder', dirname(__FILE__));
		}
		if (!Yii::getPathOfAlias('elFindervendor')) {
			Yii::setPathOfAlias('elFindervendor', Yii::getPathOfAlias('elFinder.vendor'));
		}
	}

	/**
	 * Register assets directory and return assets url path.
	 * @return string
	 */
	public static function getAssetsDir() {
		if (self::$_assetsDir === null) {
			self::registerAlias();
			$dir = Yii::getPathOfAlias('elFindervendor.assets');
			self::$_assetsDir = Yii::app()->getAssetManager()->publish($dir);
		}

		return self::$_assetsDir;
	}

	/**
	 * Try import TinyMceFileManager class.
	 */
	public static function importTinyMceFileManager() {
		if (@class_exists('TinyMceFileManager')) {
			// class already imported or declared
		} elseif (Yii::getPathOfAlias('tinymce')) {
			// try import by declared alias
			Yii::import('tinymce.TinyMceFileManager');
		} else {
			// try import by default extension directory
			Yii::import('ext.tinymce.TinyMceFileManager');
		}
	}

}
