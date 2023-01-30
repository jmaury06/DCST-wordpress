function formatResult(selection) {
  var title = jQuery(
    '<p class="selectTitle">' +
      selection.text +
      '<i class="icon-check"></i></p>'
  );
  return title;
}

function formatSelection(selection) {
    switch (selection.text) {
        case "English":
            return "ENG";
        case "French":
            return "FRE";
        case "German":
            return "DEU";
        case "Portuguese":
            return "PTS";
        default:
            return selection.text;
    }
}

(function($) {

    var Defaults = $.fn.select2.amd.require('select2/defaults');

    $.extend(Defaults.defaults, {
        dropdownPosition: 'auto'
    });

    var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

    var _positionDropdown = AttachBody.prototype._positionDropdown;

    AttachBody.prototype._positionDropdown = function() {

        var $window = $(window);

        var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
        var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

        var newDirection = null;

        var offset = this.$container.offset();

        offset.bottom = offset.top + this.$container.outerHeight(false);

        var container = {
            height: this.$container.outerHeight(false)
        };

        container.top = offset.top;
        container.bottom = offset.top + container.height;

        var dropdown = {
            height: this.$dropdown.outerHeight(false)
        };

        var viewport = {
            top: $window.scrollTop(),
            bottom: $window.scrollTop() + $window.height()
        };

        var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
        var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

        var css = {
            left: offset.left,
            top: container.bottom
        };

        // Determine what the parent element is to use for calciulating the offset
        var $offsetParent = this.$dropdownParent;

        // For statically positoned elements, we need to get the element
        // that is determining the offset
        if ($offsetParent.css('position') === 'static') {
            $offsetParent = $offsetParent.offsetParent();
        }

        var parentOffset = $offsetParent.offset();

        css.top -= parentOffset.top
        css.left -= parentOffset.left;

        var dropdownPositionOption = this.options.get('dropdownPosition');

        if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {
            newDirection = dropdownPositionOption;
        } else {

            if (!isCurrentlyAbove && !isCurrentlyBelow) {
                newDirection = 'below';
            }

            if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
                newDirection = 'above';
            } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
                newDirection = 'below';
            }

        }

        if (newDirection == 'above' ||
            (isCurrentlyAbove && newDirection !== 'below')) {
            css.top = container.top - parentOffset.top - dropdown.height;
        }

        if (newDirection != null) {
            this.$dropdown
                .removeClass('select2-dropdown--below select2-dropdown--above')
                .addClass('select2-dropdown--' + newDirection);
            this.$container
                .removeClass('select2-container--below select2-container--above')
                .addClass('select2-container--' + newDirection);
        }

        this.$dropdownContainer.css(css);

    };
})(window.jQuery);

jQuery('#language').select2({
    width: '120px',
    templateResult: formatResult,
    templateSelection: formatSelection,
    dropdownCssClass: 'language-select',
    minimumResultsForSearch: Infinity,
    dropdownPosition: 'above',
});

function changeLangCode(url, langCode) {
  var a = document.createElement('a');
  a.href = url;

  var paths = a.pathname.split('/');
    paths.shift();

  if(paths[0].length == 2) {
      if(langCode != "en") {
          paths[0] = langCode;
          setCookie('cookieLang', langCode);
      } else {
          paths.shift();
          eraseCookie('cookieLang');
      }
  }else{
      if(langCode != "en") {
          paths.unshift(langCode);
          eraseCookie('cookieLang');
      } else {
          setCookie('cookieLang', langCode);
      }
  }
    
  return a.protocol + '//' +
    a.host + '/' + paths.join('/') +
    (a.search != '' ?  a.search : '') +
    (a.hash != '' ?  a.hash : '');
}

jQuery('#language').on('change', function(){
   window.location.href = changeLangCode(window.location.href, jQuery(this).val());
});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
