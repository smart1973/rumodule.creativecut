var helpPlugin = helpPlugin || {};
helpPlugin.events = {};
helpPlugin.on = function (e, f) {
  if (!(e in this.events)) this.events[e] = [];
  this.events[e].push(f);
};
helpPlugin.off = function (e) {
  if (e in this.events) delete this.events[e];
};
helpPlugin.runEvent = function (event, args) {
  if (typeof this.events[event] == 'object') {
    for (var e = 0; e < this.events[event].length; e++) {
      this.events[event][e].apply(this, args);
    }
  }
};
helpPlugin.open = function (n) {
  if (((typeof n == 'string' && /\d+/.test(n)) || typeof n == 'number') && $('#help-' + n).length) {
    var div = $('#help-' + n).find('> div'), width, height;
    if (!div.parent().hasClass('opened')) {
      div.parent().addClass('opened');
      div.css({display: 'block'});
      width = div.width();
      height = div.height();
      div.css({width: '0px', height: '0px'});
      div.animate({width: width + 'px', height: height + 'px'}, 300);
      helpPlugin.runEvent('open', [n]);
    }
    else {
      div.animate({width: '0px', height: '0px'}, 300, function () {
        div.parent().removeClass('opened');
        div.removeAttr('style');
      });
      helpPlugin.runEvent('close', [n]);
    }
  }
};
helpPlugin.close = function (n) {
  if (((typeof n == 'string' && /\d+/.test(n)) || typeof n == 'number') && $('#help-' + n).length) {
    var div = $('#help-' + n).find('> div');
    if (div.parent().hasClass('opened')) {
      div.animate({width: '0px', height: '0px'}, 300, function () {
        div.parent().removeClass('opened');
        div.removeAttr('style');
      });
      helpPlugin.runEvent('close', [n]);
    }
  }
};
helpPlugin.closeAll = function (instant) {
  $('.help').each(function () {
    if (instant) {
      $(this).find('> div').removeAttr('style');
      $(this).removeClass('opened');
    }
    else if($(this).hasClass('opened')) helpPlugin.close(this.id.replace(/\D/g, ''));
  });
};
if (typeof helpPlugin.init == 'function') helpPlugin.init();

$(document).on('click', '.help > a', function () {
  helpPlugin.open(this.parentNode.id.replace(/\D/g, ''));
});
$(document).on('click', '.help > div > a', function () {
   helpPlugin.close(this.parentNode.parentNode.id.replace(/\D/g, ''));
});