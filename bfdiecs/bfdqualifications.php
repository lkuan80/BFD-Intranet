<section class="section section--menu" id="Shylock">
  <div class="menu menu--shylock">
    <ul class="menu__list">
      <li class="menu__item"><a href="javascript:delay('bfdiecs.php?display')" class="menu__link">BFD IECS List</a></li>
      <li class="menu__item"><a href="javascript:delay('bfdiecs.php?display=profiles')" class="menu__link">User Profiles</a></li>
      <li class="menu__item menu__item--current"><a href="javascript:delay('bfdiecs.php?display=qualifications')" class="menu__link">Qualifications</a></li>
    </ul>
  </div>
</section>

<script src="js/classie.js"></script>

<script>
function delay (URL) {
    setTimeout( function() { window.location = URL }, 500 );
}

(function() {
[].slice.call(document.querySelectorAll('.menu')).forEach(function(menu) {
  var menuItems = menu.querySelectorAll('.menu__link'),
    setCurrent = function(ev) {

      var item = ev.target.parentNode; // li

      // return if already current
      if (classie.has(item, 'menu__item--current')) {
        return false;
      }
      // remove current
      classie.remove(menu.querySelector('.menu__item--current'), 'menu__item--current');
      // set current
      classie.add(item, 'menu__item--current');
    };

  [].slice.call(menuItems).forEach(function(el) {
    el.addEventListener('click', setCurrent);

  });
});

})(window);
</script>

<section class="main-wrapper">

<div class="content">

  <h1>Work in progress...</h1>

</div>
