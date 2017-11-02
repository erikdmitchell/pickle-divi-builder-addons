// setup basic config //
var config = {
    instanceHost: "//app-aba.marketo.com",
    munchkinId: "777-AVU-348",
    formidStack: document.getElementById('MarketoformIDs').innerText.split(','),
    insertInsideSelector: "#JSFormSection",
    secondaryFormsLightbox: 'off',
    insertBeforeSelector : null, // not used
    thankYouURL: 0
}
var formCounter=1;

// extend config with passed vars //
jQuery.extend(config, MarketoFormOpts);

//console.log(config);

// utility fns
var injectMktoForm = function(parentEl, insertBeforeEl, instanceHost, munchkinId, formid, onReady) {
    var formEl = document.createElement('FORM');
    formEl.id = 'mktoForm_' + formid;
    try {
        parentEl.insertBefore(formEl, insertBeforeEl)
    } catch (e) {
        parentEl.appendChild(formEl)
    }
 
    MktoForms2.loadForm.apply(MktoForms2, Array.prototype.slice.apply(arguments, [2]));
}

var ejectElement = function(formEl) {
    formEl.parentNode.removeChild(formEl);
}

var arrayPushGet = function(ary, pushable) {
    return ary[ary.push(pushable) - 1];
}

// the real work  
var formParentEl = document.querySelector(config.insertInsideSelector) || document.body,
    formEl = formParentEl.querySelector(config.insertBeforeSelector) || null,
    formidInitialCount = config.formidStack.length,
    formElStack = [],
    formid;

var nextForm = function(values, thankYouURL) {
    if (formid = config.formidStack.shift()) {
        injectMktoForm(formParentEl, formEl, config.instanceHost, config.munchkinId, formid,

        function(form) {
	        jQuery(document).trigger('marketo_form_loaded', form);
	        
			setupQuestionIcon();
        
        	// show secondary forms in light box //
			if (formCounter > 1 && config.secondaryFormsLightbox == 'on') {
				MktoForms2.lightbox(form).show();
			}
         
            if (formEl) {               
                // nothing to eject on initial run
                ejectElement(formElStack.shift());
                
                form.addHiddenFields({
                    Email: values.Email
                });
            }

            formEl = arrayPushGet(formElStack, form.getFormElem()[0]);
            formParentEl = formEl.parentNode;

            form.onSuccess(nextForm);                
			formCounter++;
        });

        // don't forward to ThankYouURL
        return false;
    }

	// use custom url if set in module //
	if (config.thankYouURL && config.thankYouURL !== '') {
		thankYouURL=config.thankYouURL;
	}
	
   // thank you page redirect //
   location.href=thankYouURL;
   
   return false;
}

nextForm(); // first call will initialize 

var setupQuestionIcon = function() {
	var qID='';

	jQuery('.glyphicon.glyphicon-question-sign').mouseenter(function(event) {
		qID=jQuery(this).parent().attr('for');				

		var top=jQuery('.question-wrap#'+qID).data('posTop');
		var left=jQuery('.question-wrap#'+qID).data('posLeft');
		
		jQuery('.question-wrap#'+qID).css({"left": left + "px", "top": top + "px" }).show();
	});
	
	jQuery('.glyphicon.glyphicon-question-sign').mouseleave(function(event) {
		jQuery('.question-wrap#'+qID).hide();
	});	
}

jQuery(window).on('load', function(event) {
	jQuery('.et_pb_marketo_form_wrapper .form-section .mktoForm').sizeMarketoForm();
});

jQuery(window).resize(function() {
	jQuery('.et_pb_marketo_form_wrapper .form-section .mktoForm').sizeMarketoForm();
});

(function($) {
	$.fn.sizeMarketoForm = function() {	
		var elem=this;
		var formID=this.attr('id');
		var formWidth=this.width() + 10; // 10 is the padding
		var colWidth=this.parents('.et_pb_column').width();
		var formSectionWidth=$('#JSFormSection').width();

		if (formWidth <= colWidth) {
			return this;
		} else {
			setFormWidth(formID, formSectionWidth);
		}
		

	}; 
	
	function setFormWidth(formID, width) {
		$('#' + formID).width(width); 

		$('#' + formID + ' .mktoFormCol').width('100%');
		$('#' + formID + ' .mktoFieldWrap').width('100%');
		$('#' + formID + ' label').width('100%');
		$('#' + formID + ' input').css({
			'width' : '100%',
			'max-width' : '100%'
		});
 
	}
})( jQuery );
