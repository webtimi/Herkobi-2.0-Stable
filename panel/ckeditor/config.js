/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'tr';
	config.skin = 'v2';
  config.toolbar_Full =
    [
      { name: 'document', items : [ 'Source','-','Templates' ] },
      { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
      { name: 'colors', items : [ 'TextColor','BGColor' ] },
      { name: 'tools', items : [ 'HorizontalRule','SpecialChar','-','Anchor','-','Maximize', 'ShowBlocks' ] },      
      '/',
      { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
      { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
      '/',
      { name: 'styles', items : [ 'Format','Font','FontSize' ] },
      { name: 'links', items : [ 'Link','Unlink' ] },
      { name: 'insert', items : [ 'Image','Flash','Table' ] }
    ];
    config.entities = false;
    config.fullPage=false;
  config.toolbar = 'Full';
  
};