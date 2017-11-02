jQuery(document).ready(function($) {

	// set min height //
	visualMenuFixSliderHeight();
	
	// hover actions via our controller buttons //
	$('.visual-menu.slider .vm-controllers a').hover(controllerOnHover, controllerOffHover);
	
	// when you click a controller link //
/*
	$('.visual-menu.slider .vm-controllers a').on('click', function(e) {
		e.preventDefault();
		
		// swap out classes on controllers //
		removeControllersActiveClass();
		
		// change content //
		slideInactive($('.visual-menu.slider .vm-slides').find('.vm-slide.vm-active-slide').index());
		slideActive($(this).index()); // gets the number of the child		
	});
*/
	
});

function slideActive(id) {
	id=id+1; // b/c we do not start at 0
		
	var $active=jQuery('.visual-menu.slider .vm-slides .vm-slide-' + id);

	$active.addClass('vm-active-slide').fadeTo('slow', 1);
}

function slideInactive(id) {
	id=id+1; // b/c we do not start at 0
		
	var $active=jQuery('.visual-menu.slider .vm-slides .vm-slide-' + id);
	
	$active.removeClass('vm-active-slide').fadeTo('slow', 0);
}

function controllerOnHover() {
	// check if active //
	if (isAlreadyActive(jQuery(this))) {
		return false;
	}
	
	// remove active class //
	removeControllersActiveClass();
	
	// slide inactive //
	slideInactive(jQuery('.visual-menu.slider .vm-slides').find('.vm-slide.vm-active-slide').index());
	
	// add active class //
	jQuery(this).addClass('vm-active-control');
	
	// slide active //
	slideActive(jQuery(this).index());
}

function controllerOffHover() {
	//console.log('off hover should do nothing');
}

function removeControllersActiveClass() {
	jQuery('.visual-menu.slider .vm-controllers a').each(function() {
		jQuery(this).removeClass('vm-active-control');
	});	
}

function isAlreadyActive($this) {
	if ($this.hasClass('vm-active-control')) {
		return true;
	} else {
		return false;
	}
}

function visualMenuFixSliderHeight() {
	var $slider=jQuery('.visual-menu.slider');

	// no slider //
	if (!$slider.length) {
		return;
	}

	$slider.each(function() {
		var $slide=jQuery(this).find('.vm-slide'),
			$slide_container=$slide.find('.vm-container'),
			max_height = 0;

		$slide_container.css('min-height', 0);

		$slide.each(function() {
			var $this_el=jQuery(this),
				height=$this_el.innerHeight();

			if (max_height < height)
				max_height=height;
		});

		$slide_container.css('min-height', max_height);
	});
}