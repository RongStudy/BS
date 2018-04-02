// JavaScript Document
var jq = jQuery.noConflict();
jQuery(function(){
	jq(".leftNav ul li").hover(
		function(){
			jq(this).find(".fj").addClass("nuw");
			jq(this).find(".zj").show();
		}
		,
		function(){
			jq(this).find(".fj").removeClass("nuw");
			jq(this).find(".zj").hide();
		}
	)
	/**
	 * 显示微信图片
	 * @param  {[type]} ){ jq('.div_show_s').css('display', 'block');} [description]
	 * @return {[type]}     [description]
	 */
	jq('.s_sh').mouseover(function(){
    	jq('.div_show_s').css('display', 'block');
	});
	jq('.s_sh').mouseout(function(){
		jq('.div_show_s').css('display', 'none');
	})
})
