// if you want to use the 'fire' or 'disable' fn,
// you need to save OuiBounce to an object
/*
var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
	aggressive: true,
	timer: 0,
	callback: function() { console.log('ouibounce fired!'); }
});
*/
var _ouibounce = ouibounce(jQuery('.ouibounce')[0], {
	aggressive: true,
	timer: 0,
	callback: function() { console.log('ouibounce fired!'); }
});

jQuery('body').on('click', function() {
	jQuery('.et_pb_section.ouibounce').hide();
	jQuery('#ouibounce-modal').hide();
});

/*
jQuery('#ouibounce-modal .modal-footer').on('click', function() {
	jQuery('.et_pb_section.ouibounce').hide();
	jQuery('#ouibounce-modal').hide();
});
*/

jQuery('#ouibounce-modal .modal').on('click', function(e) {
	e.stopPropagation();
});