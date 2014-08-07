(function($){
	$(document).ready(function(){
		$('#types-select').change(function(){
			var $this = $(this);
			var $newTypeContainer = $('#new-type-container');
			var $newType = $newTypeContainer.find('input');

			if ($this.val() == -1 && $newTypeContainer.css('display') == 'none') {
				$newType.removeAttr('disabled').then(function(){
					$newTypeContainer.slideDown();
				});
			} else {
				$newType.attr('disabled', 'disabled').then(function(){
					$newTypeContainer.slideUp();
				});
			}
		});

		$.fn.then = function(f) {
			f();
			return this;
		};
	});
})(jQuery);