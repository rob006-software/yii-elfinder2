CHANGELOG
=========


1.0.5 (2026-11-26)
------------------

- Fix CSRF vulnerability: the client sent all commands by GET, which is not covered by CSRF validation of Yii, so a link
  opened by a logged-in user could delete, rename or overwrite files. The client now uses POST requests
  (`requestType` setting) and `ElFinderConnectorAction` rejects commands which change files when they are sent by GET
  (see `ElFinderConnectorAction::$getCommands`).
  **If you use your own client configuration** (not `ElFinderWidget` or the popup actions of this extension), set
  `requestType: 'post'` and send the CSRF token in `customData`.


1.0.4 (2017-06-04)
-------------------------

- Update elFinder to 2.0.9.
- Improve support for composer installations.


1.0.3 (2016-04-04)
------------------

- Fix issues with CSRF protection.


1.0.2 (2016-01-17)
------------------

- Update elFinder to 2.0.5.
- Aliases and paths are no longer hardcoded - extension should work better with composer installations.
- Minor improvements and bugfixes.


1.0.1 (2014-04-16)
------------------

- Switch to elFinder 2.0 branch.


1.0.0 (2014-04-14)
------------------

- Initial release.
