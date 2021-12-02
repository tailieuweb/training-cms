"use strict";
jQuery(document).ready(function(){
	jQuery('#wpfMailTestForm').submit(function(){
		jQuery(this).sendFormWpf({
			btn: jQuery(this).find('button:first')
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#wpfMailTestForm').slideUp( 300 );
					jQuery('#wpfMailTestResShell').slideDown( 300 );
				}
			}
		});
		return false;
	});
	jQuery('.wpfMailTestResBtn').click(function(){
		var result = parseInt(jQuery(this).data('res'));
		jQuery.sendFormWpf({
			btn: this
		,	data: {mod: 'mail', action: 'saveMailTestRes', result: result}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#wpfMailTestResShell').slideUp( 300 );
					jQuery('#'+ (result ? 'wpfMailTestResSuccess' : 'wpfMailTestResFail')).slideDown( 300 );
				}
			}
		});
		return false;
	});
	jQuery('#wpfMailSettingsForm').submit(function(){
		jQuery(this).sendFormWpf({
			btn: jQuery(this).find('button:first')
		});
		return false; 
	});
});