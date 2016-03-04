
(function( $ ){	
	$.fn.Pagination = function(target,options) {
		var opts = $.extend($.fn.Pagination.defaults, options);  
		return this.each(function() {
			$.fn.Pagination.init(target, opts);
		});
	};
	$.fn.Pagination.init = function(target,opts){
		opts.more();
		target.on(
			"click",
			function(){
				opts.loading();  //执行loading
				$.get(
				 	opts.url+"&page="+opts.page,
					function(json){
						if (json) opts.finish(json);  //执行finish
						opts.page++;
					}
				);
			}
		)

	}
	$.fn.Pagination.defaults = {
		more : function(){},
		loading : function(){},
		finish: function(){},
		stop : function(){},
		url : null,
		page : 2
	};	
})( jQuery );