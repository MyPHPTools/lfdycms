var curIndex = 0;
var time = 800;
var slideTime = 5000;
var int = setInterval("autoSlide()", slideTime);
$("#banner_img>li").first().show();
$('#banner_ctr>ul>li').first().addClass('on');
$('#banner_link').attr('href',$("#banner_img>li").first().children('a').attr('href'));

$('#banner_ctr>ul>li').each(function() {
	$(this).mouseDelay(false).hover(function(event) {
		var ct = $(this).index();
		if(ct<=0){
			ct=0;
		}
		$(this).addClass('cur').siblings().removeClass('on');
		
		show(ct);
		window.clearInterval(int);
		int = setInterval("autoSlide(0)", slideTime);
	});
});

function autoSlide(ct) { 
	var zbn=$('#banner_img>li').length;
	curIndex + 1 >= zbn? curIndex = -1 : 0;
	show(curIndex + 1);
	
}
function show(index) {
	$.easing.def = "easeOutQuad";
	$("#banner_img>li").eq(curIndex).show().siblings().hide();
	var href = $("#banner_img>li").eq(index).children('a').attr('href');
	$('#banner_link').attr('href',href);
	setTimeout(function () {
		$("#banner_img>li").eq(index).show().siblings().hide();
		$('#banner_ctr>ul>li').eq(index).addClass('on').siblings().removeClass('on');
	}, 200);
	curIndex = index;

}