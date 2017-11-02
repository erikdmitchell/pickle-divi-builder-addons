jQuery(document).ready(function($) {
	
	if ($('.et_pb_icon_hover_list').length > 0) {
		var $detailBox=$('#detail-box');
		
		jQuery('.et_pb_icon_list_item').mouseenter(function() {
			$detailBox.hide();
			$detailBox.html($(this).find('.text-wrap').html());
			
			$detailBox.css({
				'left' : $(this).width(),
			});		
			
			$detailBox.show(200);
		});
		
		jQuery('.et_pb_icon_list_item').mouseleave(function() {
			$detailBox.hide();
		});
	}
	
});