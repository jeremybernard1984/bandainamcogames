/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = 'js/lib/kcfinder/browse.php?opener=ckeditor&type=files';
   config.filebrowserImageBrowseUrl = 'js/lib/kcfinder/browse.php?opener=ckeditor&type=images';
   config.filebrowserFlashBrowseUrl = 'js/lib/kcfinder/browse.php?opener=ckeditor&type=flash';
   config.filebrowserUploadUrl = 'js/lib/kcfinder/upload.php?opener=ckeditor&type=files';
   config.filebrowserImageUploadUrl = 'js/lib/kcfinder/upload.php?opener=ckeditor&type=images';
   config.filebrowserFlashUploadUrl = 'js/lib/kcfinder/upload.php?opener=ckeditor&type=flash';
   
   
   // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
config.toolbar = [
	
	{ name: 'clipboard', 
		groups: [ 'clipboard', 'undo' ], 
		items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	
	{ name: 'basicstyles', 
		items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Superscript', ] },
	{ name: 'paragraph', 
		items: [ 'NumberedList', 'BulletedList' ]},
	{ name: 'links', 
		items: [ 'Link', 'Unlink', 'Anchor' ] }
	
];

// Toolbar groups configuration.
config.toolbarGroups = [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'forms' },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	{ name: 'links' },
	{ name: 'insert' },
	'/',
	{ name: 'styles' },
	{ name: 'colors' },
	{ name: 'tools' },
	{ name: 'others' },
	{ name: 'about' }
];
   
   
   
};
