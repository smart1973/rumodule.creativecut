$(document).ready(function () {
	popup.init();
	if ($('table#cart').length) {
		(function () {
			var toPriceFormat = function (n) {
				return n.toLocaleString('de-DE',{style:'currency',currency:'EUR'}).replace(/[^\d\.,]/gi,'').replace(/[\.,]/g,function(v){var r={'.':',',',':'.'};return r[v];});
			}, calculateTotalPrice = function () {
				var totalForBids = 0, totalTax = 0;
				$('table#cart > tbody > tr').each(function () {
					totalForBids += parseFloat($(this).attr('bid-price')) * parseInt($(this).find('input[type="number"][name^="quantity["]').val());
					totalTax += parseFloat($(this).attr('bid-tax')) * parseInt($(this).find('input[type="number"][name^="quantity["]').val());
				});
				$('#cart-price-for-bids').text(toPriceFormat(totalForBids));
				$('#cart-tax').text(toPriceFormat(totalTax));
				var totalPrice = totalForBids + totalTax + parseFloat($('input[type="radio"][name="delivery_time"]:checked').attr('price')), discountPercents, discount = 0;
				if ((discountPercents = $('#cart-discount').attr('discount-percents')) && /^\d+$/.test(discountPercents)) {
					discount = totalPrice / 100 * parseFloat(discountPercents);
					totalPrice -= discount;
				}
				$('#cart-discount').text(toPriceFormat(discount));
				$('#cart-total-price').text(toPriceFormat(totalPrice));
			};
			$('input[type="radio"][name="delivery_time"]').change(function () {
				$('#cart-delivery-price').text(toPriceFormat(parseFloat($('input[type="radio"][name="delivery_time"]:checked').attr('price'))));
				calculateTotalPrice();
			});
			$('input[type="number"][name^="quantity["]').bind('keyup change click', calculateTotalPrice);

			$('#cart-check-coupon').click(function () {
				if (!$('input[type="text"][name="coupon"]').val()) creativecut_alert('לא נרשם קוד קופון');
				else {
					$.ajax({
						url: '/check-coupon',
						method : 'post',
						data: {
							coupon: $('input[type="text"][name="coupon"]').val()
						},
						success: function (res) {
							try {
								var r = JSON.parse(res);
								if (!('status' in r) || ((r.status != 'success' || !('discount' in r) || (typeof r.discount != 'string') || !/^\d+$/.test(r.discount)) && (r.status != 'error' || !('type' in r) || (typeof r.type != 'string')))) throw '';
								if (r.status == 'error') throw [r.type];
								else {
									$('#cart-discount-wrapper').css('display', 'block');
									$('#cart-discount').attr('discount-percents', r.discount);
								}
							}
							catch (ex) {
								$('#cart-discount-wrapper').css('display', 'none');
								$('#cart-discount').attr('discount-percents', 0);
								creativecut_alert((typeof ex == 'object') ? ex[0] : 'Error');
							}
							calculateTotalPrice();
						}
					});
				}
				return false;
			});
		})();
	}

	$('.social-login a').click(function () {
		var width = 450, height = 450,
		left = (window.innerWidth - width) / 2, top = (window.innerHeight - height) / 2;
		popup_window = window.open(this.href, this.getAttribute('id'), 'top=' + top + ',left=' + left + ',location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,titlebar=yes,toolbar=no,channelmode=yes,fullscreen=yes,width=' + width + ',height=' + height);
		popup_window.focus();
		return false;
	});

	$('#prompts-controll input[type="checkbox"]').change(function () {
		setCookie('user_is_newbie', this.checked ? 'yes' : 'no');
	});
	(function () {
		var p, initEvents = false,
		creativeCutInit = function () {
			creativeCutPainter.on('file saved successfully', function () {
				setCookie('user_is_newbie', 'no');
				$('#prompts-controll input[type="checkbox"]')[0].checked = false;
			});
			creativeCutPainter.on('load file', function () {
				$('#help-6').css({top: $('h2#material-size-control-title')[0].offsetTop - 1 + 'px', right: '-30px'});
				helpPlugin.closeAll(true);
				if (getCookie('user_is_newbie') === 'yes') {
					p = {1: 2, 2: 3, 3: 4, 4: 5, 5: 6, 6: 7};
					helpPlugin.open(1);
				}
				else p = {};
				if (!initEvents) {
					initEvents = true;
					helpPlugin.on('close', function (n) {
						if (typeof p[n] == 'number') {
							if ($('#help-' + p[n]).length && !$('#help-' + p[n]).hasClass('opened')) helpPlugin.open(p[n]);
							delete p[n];
						}
					});
					helpPlugin.on('open', function (n) {
						for (var k in p) {
							if (p[k] == n) delete p[k];
						}
					});
				}
			});
		};
		if (typeof creativeCutPainter == 'object') creativeCutInit();
		else window.creativeCutPainter = {init: creativeCutInit};
	})();

	$('#send-phone-message').click(function () {
		try {
			var tel, _this = this;
			if (!$('input[type="text"][name="phone"]').length) throw 'Field phone is miss';
			if (!(tel = $('input[type="text"][name="phone"]').val())) throw 'Не введен телефон';
			if (!/^\d{10}$/.test(tel)) throw 'Wrong phone format';

			$(this).css('display', 'none');
			$('#send-phone-message-spinner').css('display', 'block');

			$.ajax({
				url: '/sendSms',
				type: 'post',
				data: {
					phone_number: tel
				},
				success: function (r) {
					$(_this).css('display', 'block');
					$('#send-phone-message-spinner').css('display', 'none');
					alert(r);
				}
			});
		}
		catch (e) {
			alert(e);
		}
		return false;
	});

	$('.view-options').click(function () {
		popup.show($(this).closest('.bid-wrapper').parent().find('.bid-detail-wrapper').html());
		return false;
	});

	$('.show-popup').click(function () {
		popup.show($(this).attr('popup-content'), [$(this).attr('popup-width') || 300, $(this).attr('popup-height') || 300]);
		return false;
	});

	$('.smart-input li').click(function () {
		$(this).parent().prev().val($(this).text());
	});
	$(document).click(function (ev) {
		$('.smart-input ul').each(function () {
			if ($(this).css('display') == 'block' && (ev.target.tagName != 'INPUT' || $(ev.target).attr('type') != 'text' || ev.target != $(this).prev()[0])) {
				$(this).css('display', 'none');
			}
			else if ($(this).css('display') == 'none' && ev.target.tagName == 'INPUT' && $(ev.target).attr('type') == 'text' && ev.target == $(this).prev()[0]) {
				$(this).prev().keyup();
			}
		});
	});
	$('.smart-input input').keyup(function () {
		var thisVal = $(this).val();
		$(this).next().find('li').each(function () {
			if (thisVal && $(this).text().toLowerCase().indexOf(thisVal.toLowerCase()) === -1) $(this).css('display', 'none');
			else $(this).css('display', 'block');
		});
		$(this).next().css('display', 'block');
	});

	(function () {
		var checkScroll = function () {
			var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			$('.info-message:not(.closed)').each(function () {
				if (scrollTop && window.innerWidth > 845) $('.info-message').addClass('opened');
				else $('.info-message').removeClass('opened');
			});
		};
		$(window).resize(checkScroll);
		$(window).on('load', checkScroll);
		$(window).scroll(checkScroll);
	})();
	$('.info-message-close').click(function () {
		$(this).parent().removeClass('opened').addClass('closed');
	});
});

var popup = {
	init: function () {
		if (!$('#popup-wrapper').length) {
			$('body').append('<div id="popup-wrapper"><div id="popup"><div id="popup-close"></div><div id="popup-inner"></div></div></div>');
		}
		$(document).click(function (el) {
			if (el.target.id == 'popup-wrapper' || el.target.id == 'popup-close') popup.hide();
		});
	},
	show: function (content, sizes) {
		if (!sizes || typeof sizes != 'object') sizes = [300, 300];
		$('#popup-wrapper').css('display', 'block');
		$('#popup-inner').html(content);
		$('#popup').css({width: sizes[0] + 'px', height: sizes[1] + 'px'});
		$('body').css('overflow', 'hidden');
	},
	hide: function () {
		$('#popup-wrapper').css('display', 'none');
		$('body').css('overflow', 'visible');
	}
};
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
    '(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'
  ));
  return matches ? decodeURIComponent(matches[1]) : false;
}
function setCookie(name, val) {
	document.cookie = name + ' = ' + encodeURIComponent(val) + '; path=/; expires=0';
}
function creativecut_alert(msg) {
	var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
		"\r": '<br>',
		"\n": '<br>'
  };

	if ($('#creativecut-alert-message-wrapper').length) $('#creativecut-alert-message').html(msg.replace(/[&<>"'\r\n]/g, function(m) {return map[m];}));
	else {
		var html = '<div id="creativecut-alert-message-window">';
		html += '<div id="creativecut-alert-message">' + msg.replace(/[&<>"'\r\n]/g, function(m) {return map[m];}) + '</div>';
		html += '<button id="creativecut-alert-message-button">אישור</button>';
		html += '</div>';

		$('body').css('overflow', 'hidden').append('<div id="creativecut-alert-message-wrapper">' + html + '</div>');
		$('#creativecut-alert-message-button').click(function () {
			$('#creativecut-alert-message-wrapper').remove();
			$('body').css('overflow', 'visible');
		});
	}
}
function creativecut_confirm(msg, ok, cancel) {
	var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
		"\r": '<br>',
		"\n": '<br>'
  };

	var html = '<div id="creativecut-confirm-window">';
	html += '<div id="creativecut-confirm-message">' + msg.replace(/[&<>"'\r\n]/g, function(m) {return map[m];}) + '</div>';
	html += '<button id="creativecut-confirm-ok-button">Подтвердить</button>';
	html += '<button id="creativecut-confirm-cencel-button">Отмена</button>';
	html += '</div>';

	if ($('#creativecut-confirm-wrapper').length) $('#creativecut-confirm-wrapper').html(html);
	else $('body').css('overflow', 'hidden').append('<div id="creativecut-confirm-wrapper">' + html + '</div>');

	document.getElementById('creativecut-confirm-ok-button').onclick = function () {
		if (ok && typeof ok == 'function') ok();
		$('#creativecut-confirm-wrapper').remove();
		$('body').css('overflow', 'visible');
	};
	document.getElementById('creativecut-confirm-cencel-button').onclick = function () {
		if (cancel && typeof cancel == 'function') cancel();
		$('#creativecut-confirm-wrapper').remove();
		$('body').css('overflow', 'visible');
	};

	return false;
}