

	
jQuery(document).ready(function(){
	var accordionsMenu = $('.cd-accordion-menu');

	if( accordionsMenu.length > 0 ) {
		
		accordionsMenu.each(function(){
			var accordion = $(this);

			accordion.on('change', 'input[type="checkbox"]', function(){
				var checkbox = $(this);

				( checkbox.prop('checked') ) ? checkbox.siblings('ul').attr('style', 'display:none;').slideDown(300) : checkbox.siblings('ul').attr('style', 'display:block;').slideUp(300);
			});
		});
	}
});


var AnimatedHeader = (function () {
    var b = document.documentElement, g = document.querySelector("#header"), e = false, a = 100;

    function f() {
        window.addEventListener("scroll", function (h) {
            if (!e) {
                e = true;
                setTimeout(d, 100)
            }
        }, false)
    }

    function d() {
        var h = c();
        if (h >= a) {
            classie.add(g, "navbar-hide-top-bar")
        } else {
            classie.remove(g, "navbar-hide-top-bar")
        }
        e = false
    }

    function c() {
        return window.pageYOffset || b.scrollTop
    }

    f()
})();



$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav-tabs-order a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });
});



$(function () {
    $('#product-slider').carousel({
        interval:3000,
        pause: "false"
    });
    $('#playButton').click(function () {
        $('#product-slider').carousel('cycle');
    });
    $('#pauseButton').click(function () {
        $('#product-slider').carousel('pause');
    });
});
