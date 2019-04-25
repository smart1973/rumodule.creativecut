$(document).ready(function () {
	$('.tabs > ul:first-child > li > a').each(function (n) {
		$(this).click(function () {
			$(this).parent().parent().find('> li').removeClass('active');
			$(this).parent().addClass('active');
			$(this).parent().parent().parent().find('> ul:last-child > li').removeClass('active');
			$(this).parent().parent().parent().find('> ul:last-child > li:nth-child(' + (n + 1) + ')').addClass('active');
		});
	});
});