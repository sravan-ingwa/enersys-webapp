/* ===========================================================
 * bootstrap-confirmationx.js v1.0.1
 * http://ethaizone.github.io/Bootstrap-confirmationx/
 * ===========================================================
 * Copyright 2013 Nimit Suwannagate <ethaizone@hotmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * =========================================================== */


!function ($) {

	"use strict"; // jshint ;_;


 /* confirmationx PUBLIC CLASS DEFINITION
	* =============================== */

	//var for check event at body can have only one.
	var event_body = false;

	var confirmationx = function (element, options) {
		var that = this;

		// remove href attribute of button
		$(element).removeAttr('href')

		this.init('confirmationx', element, options)

		$(element).on('show', function(e) {
			var options = that.options;
			var all = options.all_selector;
			if(options.singleton) {
				$(all).not(that.$element).confirmationx('hide');
			}
		});

		$(element).on('shown', function(e) {
			var options = that.options;
			var all = options.all_selector;
			$(this).next('.popover').one('click.dismiss.confirmationx', '[data-dismiss="confirmationx"]', $.proxy(that.hide, that))
			if(that.isPopout()) {
				if(!event_body) {
					event_body = $('body').on('click', function (e) {
						if($(all).is(e.target)) return;
						if($(all).has(e.target).length) return;
						if($(all).next('div').has(e.target).length) return;

						$(all).confirmationx('hide');
						$('body').unbind(e);
						event_body = false;

						return;
					});
				}
			}
		});
	}


	/* NOTE: confirmationx EXTENDS BOOTSTRAP-TOOLTIP.js
		 ========================================== */

	confirmationx.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype, {

		constructor: confirmationx

		, setContent: function () {
				var $tip = this.tip()
					, $btnOk = this.btnOk()
					, $btnCancel = this.btnCancel()
					, title = this.getTitle()
					, href = this.getHref()
					, target = this.getTarget()
					, $e = this.$element
					, btnOkClass = this.getBtnOkClass()
					, btnCancelClass = this.getBtnCancelClass()
					, btnOkLabel = this.getBtnOkLabel()
					, btnCancelLabel = this.getBtnCancelLabel()
					, o = this.options

				$tip.find('.popover-title').text(title)

				$btnOk.addClass(btnOkClass).html(btnOkLabel).attr('href', href).attr('target', target).on('click', o.onConfirm)
				$btnCancel.addClass(btnCancelClass).html(btnCancelLabel).on('click', o.onCancel)

				$tip.removeClass('fade top bottom left right in')
			}

		, hasContent: function () {
				return this.getTitle()
			}

		, isPopout: function () {
				var popout
					, $e = this.$element
					, o = this.options

				popout = $e.attr('data-popout') || (typeof o.popout == 'function' ? o.popout.call($e[0]) :	o.popout)

				if(popout == 'false') popout = false;

				return popout
			}


		, getHref: function () {
				var href
					, $e = this.$element
					, o = this.options

				href = $e.attr('data-href') || (typeof o.href == 'function' ? o.href.call($e[0]) :	o.href)

				return href
			}

		, getTarget: function () {
				var target
					, $e = this.$element
					, o = this.options

				target = $e.attr('data-target') || (typeof o.target == 'function' ? o.target.call($e[0]) :	o.target)

				return target
			}

		, getBtnOkClass: function () {
				var btnOkClass
					, $e = this.$element
					, o = this.options

				btnOkClass = $e.attr('data-btnOkClass') || (typeof o.btnOkClass == 'function' ? o.btnOkClass.call($e[0]) :	o.btnOkClass)

				return btnOkClass
			}

		, getBtnCancelClass: function () {
				var btnCancelClass
					, $e = this.$element
					, o = this.options

				btnCancelClass = $e.attr('data-btnCancelClass') || (typeof o.btnCancelClass == 'function' ? o.btnCancelClass.call($e[0]) :	o.btnCancelClass)

				return btnCancelClass
			}

		, getBtnOkLabel: function () {
				var btnOkLabel
					, $e = this.$element
					, o = this.options

				btnOkLabel = $e.attr('data-btnOkLabel') || (typeof o.btnOkLabel == 'function' ? o.btnOkLabel.call($e[0]) :	o.btnOkLabel)

				return btnOkLabel
			}

		, getBtnCancelLabel: function () {
				var btnCancelLabel
					, $e = this.$element
					, o = this.options

				btnCancelLabel = $e.attr('data-btnCancelLabel') || (typeof o.btnCancelLabel == 'function' ? o.btnCancelLabel.call($e[0]) :	o.btnCancelLabel)

				return btnCancelLabel
			}

		, tip: function () {
				this.$tip = this.$tip || $(this.options.template)
				return this.$tip
			}

		, btnOk: function () {
				var $tip = this.tip()
				return $tip.find('.popover-content > div > a:not([data-dismiss="confirmationx"])')
			}

		, btnCancel: function () {
				var $tip = this.tip()
				return $tip.find('.popover-content > div > a[data-dismiss="confirmationx"]')
			}

		, hide: function () {
				var $btnOk = this.btnOk()
					, $btnCancel = this.btnCancel()

				$.fn.tooltip.Constructor.prototype.hide.call(this)

				$btnOk.off('click')
				$btnCancel.off('click')

				return this
			}

		, destroy: function () {
				this.hide().$element.off('.' + this.type).removeData(this.type)
			}

	})


 /* confirmationx PLUGIN DEFINITION
	* ======================= */

	var old = $.fn.confirmationx

	$.fn.confirmationx = function (option) {
		var that = this
		return this.each(function () {
			var $this = $(this)
				, data = $this.data('confirmationx')
				, options = typeof option == 'object' && option
			options = options || {}
			options.all_selector = that.selector
			if (!data) $this.data('confirmationx', (data = new confirmationx(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.confirmationx.Constructor = confirmationx

	$.fn.confirmationx.defaults = $.extend({} , $.fn.tooltip.defaults, {
		placement: 'left'
		, trigger: 'click'
		, target : '_self'
		//, href   : ''
		, title  : 'Enter your email ID'
		, template: '<div class="popover">' +
				'<div class="arrow"></div>' +
				'<h3 class="popover-title" style="color:#000;"></h3>' +
				'<div class="confir" style="width:250px;padding:15px;">'+
				'<form id="defaultForm"><input type="email" class="form-control" id="send" name="send" placeholder="E-Mail ID"/></form>'+
				'</div>' +
				'<div class="popover-content text-center">' +
				'<div class="btn-group">' +
				'<a class="btn btn-small" target=""></a>' +
				'<a class="btn btn-small" data-dismiss="confirmationx"></a>' +
				'</div>' +
				'</div>' +
				'</div>'
		, btnOkClass:  'btn-danger'
		, btnCancelClass:  'btn-primary'
		, btnOkLabel: '<span class="glyphicon glyphicon-ok"></span>&nbsp;Send'
		, btnCancelLabel: '<span class="glyphicon glyphicon-remove"></span>&nbsp;Cancel'
		, singleton: false
		, popout: false
		, onConfirm: function(){
					var send = document.getElementById('send').value;
					var x = document.getElementById('x').value;
					var y = document.getElementById('y').value;
					$('#myText').html("<div class='alert alert-success' role='alert'>Mail Successfully Sent to "+send+"</div>");
					$(".popover").fadeOut(2000);
			$.ajax({
					type: "POST",
					url: "mail.php",
					data: 'send='+send+'&x='+x+'&y='+y,
					cache: false,
					success: function(result){}
				});
			}
		, onCancel: function(){}
	})


 /* POPOVER NO CONFLICT
	* =================== */

	$.fn.confirmationx.noConflict = function () {
		$.fn.confirmationx = old
		return this
	}

}(window.jQuery);
