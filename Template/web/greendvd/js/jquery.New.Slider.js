var curIndex = 0;
var time = 800;
var slideTime = 5000;
var int = setInterval("autoSlide()", slideTime);
$("#banner_img>li").first().addClass('active');
$('#banner_ctr>ul>li').first().addClass('cur');


$('#banner_ctr>ul>li').each(function() {
	$(this).mouseDelay(false).hover(function(event) {
		var ct = $(this).index();
			if(ct<=0){
			ct=0;
		}
		$(this).addClass('cur').siblings().removeClass('cur');
		
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
	$("#banner_img>li").eq(curIndex).addClass('active').siblings().removeClass('active');
	setTimeout(function () {
		$("#banner_img>li").eq(index).addClass('active').siblings().removeClass('active');
		$('#banner_ctr>ul>li').eq(index).addClass('cur').siblings().removeClass('cur');
	}, 200);
	curIndex = index;

}