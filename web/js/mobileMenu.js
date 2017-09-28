document.addEventListener("DOMContentLoaded", function() {
  function remove(string) {
    return {
      from: function(fullString) {
        return fullString.replace(' '.concat(string), '');
      }
    }
  };

  function add(string) {
    return {
      to: function(fullString) {
        return fullString.concat(' '.concat(string));
      }
    }
  };

  var menu = document.querySelector('input.MobileHeader-openPrimaryMenu');

  menu.addEventListener("click", function toogleMenu() {
    var toggleClass = 'is-leftNavOpen';
    var body = document.querySelector('body');
    var bodyClass = body.getAttribute('class');
    var isMenuOpen = bodyClass.indexOf(toggleClass) > -1;

    if (isMenuOpen) {
      var className = remove(toggleClass).from(bodyClass);

      body.setAttribute('class', className);
    } else {
      var className = add(toggleClass).to(bodyClass);

      body.setAttribute('class', className);
    }
  });
});
