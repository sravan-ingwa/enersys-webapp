/* ===========================================================
 * bootstrap-confirmation.js v1.0.1
 * http://ethaizone.github.io/Bootstrap-Confirmation/
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


 /* CONFIRMATION PUBLIC CLASS DEFINITION
	* =============================== */

	//var for check event at body can have only one.
	var event_body = false;

	var Confirmation = function (element, options) {
		var that = this;
		// remove href attribute of button
		$(element).removeAttr('href')
		this.init('confirmation', element, options)

		$(element).on('show', function(e) {
			var options = that.options;
			var all = options.all_selector;
			if(options.singleton) {
				$(all).not(that.$element).confirmation('hide');
			}
		});

		$(element).on('shown', function(e) {
			var options = that.options;
			var all = options.all_selector;
			$(this).next('.popover').one('click.dismiss.confirmation', '[data-dismiss="confirmation"]', $.proxy(that.hide, that))
			if(that.isPopout()) {
				if(!event_body) {
					event_body = $('body').on('click', function (e) {
						if($(all).is(e.target)) return;
						if($(all).has(e.target).length) return;
						if($(all).next('div').has(e.target).length) return;

						$(all).confirmation('hide');
						$('body').unbind(e);
						event_body = false;

						return;
					});
				}
			}
		});
	}


	/* NOTE: CONFIRMATION EXTENDS BOOTSTRAP-TOOLTIP.js
		 ========================================== */

	Confirmation.prototype = $.extend({}, $.fn.tooltip.Constructor.prototype, {

		constructor: Confirmation

		, setContent: function () {
				var $tip = this.tip()
					, $btnOk = this.btnOk()
					, $btnCancel = this.btnCancel()
					, title = this.getTitle()
					, href = this.getHref()
					, conttent = this.getConttent()
					, target = this.getTarget()
					, $e = this.$element
					, btnOkClass = this.getBtnOkClass()
					, btnCancelClass = this.getBtnCancelClass()
					, btnOkLabel = this.getBtnOkLabel()
					, btnCancelLabel = this.getBtnCancelLabel()
					, o = this.options

				$tip.find('.popover-title').text(title)

				$btnOk.addClass(btnOkClass).html(btnOkLabel).attr('namex', conttent).attr('href', href).attr('target', target).on('click', o.onConfirm)
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
		, getConttent: function () { 
				var Conttent
					, $e = this.$element
					, o = this.options

				Conttent = $e.attr('data-Conttent') || (typeof o.Conttent == 'function' ? o.Conttent.call($e[0]) :	o.Conttent)
					//alert(Conttent);
				return Conttent
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
				return $tip.find('.popover-content > div > a:not([data-dismiss="confirmation"])')
			}

		, btnCancel: function () {
				var $tip = this.tip()
				return $tip.find('.popover-content > div > a[data-dismiss="confirmation"]')
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


 /* CONFIRMATION PLUGIN DEFINITION
	* ======================= */

	var old = $.fn.confirmation

	$.fn.confirmation = function (option) {
		var that = this
		return this.each(function () {
			var $this = $(this)
				, data = $this.data('confirmation')
				, options = typeof option == 'object' && option
			options = options || {}
			options.all_selector = that.selector
			if (!data) $this.data('confirmation', (data = new Confirmation(this, options)))
			if (typeof option == 'string') data[option]()
		})
	}

	$.fn.confirmation.Constructor = Confirmation

	$.fn.confirmation.defaults = $.extend({} , $.fn.tooltip.defaults, {
		placement: 'left'
		, trigger: 'click'
		, target : '_self'
		//, href   : '#'
		, title  : 'Are you sure you want to delete ?'
		, template: '<div class="popover">' +
				'<div class="arrow"></div>' +
				'<h3 class="popover-title"></h3>' +
				'<div class="popover-content text-center colo">' +
				'<div class="btn-group">' +
				'<a class="btn btn-small colo" target=""></a>' +
				'<a class="btn btn-small" data-dismiss="confirmation"></a>' +
				'</div>' +
				'</div>' +
				'</div>'
		, btnOkClass:  'btn-danger'
		, btnCancelClass:  'btn-primary'
		, btnOkLabel: '<i class="glyphicon glyphicon-ok"></i> &nbsp;Delete'
		, btnCancelLabel: '<i class="glyphicon glyphicon-remove"></i>&nbsp; Cancel'
		, singleton: true
		, popout: true
		, onConfirm: function(){
			$.ajax({
					type: "POST",
					url: "delete.php",
					data: 'del='+$(this).attr('namex'),
					cache: false,
					success: function(result){
						document.getElementById("myText").innerHTML = "<div class='alert alert-success' role='alert'>Successfully Deleted</div>";
						setTimeout(function(){window.location='index.php?x='+result;}, 1000);
					/*location.reload();*/ }
				});
			
		}
		, onCancel: function(){}
	})


 /* POPOVER NO CONFLICT
	* =================== */

	$.fn.confirmation.noConflict = function () {
		$.fn.confirmation = old
		return this
	}

}(window.jQuery);
