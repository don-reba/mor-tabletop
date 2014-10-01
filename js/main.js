// handle mail subscriptions
$(document).ready(function()
{
	// navigation
	var contentSections = $('.cd-section'),
	navigationItems = $('#cd-vertical-nav a');

	updateNavigation();
	$(window).on('scroll', function() {
		updateNavigation();
	});

	//smooth scroll to the section
	navigationItems.on('click', function(event) {
		event.preventDefault();
		smoothScroll($(this.hash));
	});

	//open-close navigation on touch devices
	$('.no-touch .cd-nav-trigger').on('click', function() {
		$('.no-touch #cd-vertical-nav').toggleClass('open');

	});
	//close navigation on touch devices when selectin an elemnt from the list
	$('.no-touch #cd-vertical-nav a').on('click', function() {
		$('.no-touch #cd-vertical-nav').removeClass('open');
	});

	function updateNavigation()
	{
		contentSections.each(function() {
			$this = $(this);
			var activeSection = $('#cd-vertical-nav a[href="#'+$this.attr('id')+'"]').data('number') - 1;
			if ( ( $this.offset().top - $(window).height()/2 < $(window).scrollTop() ) && ( $this.offset().top + $this.height() - $(window).height()/2 > $(window).scrollTop() ) ) {
				navigationItems.eq(activeSection).addClass('is-selected');
				}else {
				navigationItems.eq(activeSection).removeClass('is-selected');
			}
		});
	}

	function smoothScroll(target)
	{
		$('body,html').animate(
		{'scrollTop':target.offset().top},
		600
		);
	}

	// fix #top for iOS
	window.viewportUnitsBuggyfill.init();

	// bind 'mailForm'
	function StripHtml(html)
	{
		var body    = html.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '');
		var content = $(body);
		content.find('a').remove();
		content.find('br').replaceWith(' ');
		return content.text();
	}
	var options = {
		clearForm : true,
		data      : { lang : $('html').attr('lang') },

		success : function(result) {
			$('#subscribeResponse').text(StripHtml(result));
		}
	};
	$('#mailForm').ajaxForm(options);

	// google analytics
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-54185350-1', 'auto');
	ga('send', 'pageview');
});
