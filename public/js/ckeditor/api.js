/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var editor;

	// The instanceReady event is fired, when an instance of CKEditor has finished
	// its initialization.
	CKEDITOR.on( 'instanceReady', function( ev ) {
		editor = ev.editor;

		// Show this "on" button.
		document.getElementById( 'readOnlyOn' ).style.display = '';

		// Event fired when the readOnly property changes.
		editor.on( 'readOnly', function() {
			document.getElementById( 'readOnlyOn' ).style.display = this.readOnly ? 'none' : '';
			document.getElementById( 'readOnlyOff' ).style.display = this.readOnly ? '' : 'none';
		});
	});

	function toggleReadOnly( isReadOnly ) {
		editor.setReadOnly( isReadOnly );
	}


	function GetContents() {
		// Get the editor instance that you want to interact with.
		var editor = CKEDITOR.instances.editor;

		// Get editor contents
		// http://docs.ckeditor.com/#!/api/CKEDITOR.editor-method-getData
		$('#article').val(editor.getData());
		
		return true;
	}
		
	//POUR LA MISE A JOUR DES DONNEES
	function InsertHTML() { 
		var editor = CKEDITOR.instances.editor;
		var value = $("#article").val();
		editor.setData( value );
	}
