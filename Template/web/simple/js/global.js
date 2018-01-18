$(function(){
	if($('div').is('.swiper-container')){
		var slider_swiper = new Swiper ('.swiper-container', {
			autoplay : 3000,
		    loop: true,
		    // 如果需要分页器
		    pagination: '.swiper-number',
		    paginationElement : 'a',
		    paginationClickable :true,
	 	}) 
	}
});