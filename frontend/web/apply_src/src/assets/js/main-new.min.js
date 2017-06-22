var app={};app.isPC=false;app.width;app.height;app.loop=false;app.DEFAULT_WIDTH=414;app.DEFAULT_HEIGHT=736;app.init=function(options){options=options||{};app.loop=options.loop||getUrlParameterByName('loop')||false;if(checkIsPC()){app.isPC=true;app.width=app.DEFAULT_WIDTH;app.height=Math.min(app.DEFAULT_HEIGHT,app.height);}
var swiperOptions=$.extend({direction:'vertical',loop:app.loop,longSwipesRatio:0.1,preventClicks:false,preventClicksPropagation:false},options||{});app.initPC();app.music.init();$('.home-btn').on('click',function(){app.swiper.slideTo(0);return false;});if(options.hashnav){$(window).on('hashchange',function(e){var hash=getLocationHash().replace('#','');if(!hash){return;}
for(var i=0,length=app.swiper.slides.length;i<length;i++){var slide=$(app.swiper.slides).eq(i);var slideHash=slide.attr('data-hash');if(slideHash===hash&&!slide.hasClass(app.swiper.params.slideDuplicateClass)){var index=slide.index();if(app.swiper.activeIndex==index){return;}
app.swiper.slideTo(index);}}});}};function getLocationHash(){var index=location.href.indexOf('#');var url=index===-1?'':location.href.slice(index+1);return url;}
function getUrlParameterByName(name){name=name.replace(/[\[]/,'\\[').replace(/[\]]/,'\\]');var regex=new RegExp('[\\?&]'+name+'=([^&#]*)'),results=regex.exec(location.search);return results===null?'':decodeURIComponent(results[1].replace(/\+/g,' '))}
app.initPC=function(){if(!app.isPC){return false;}
var left=$(window).width()/2+app.width/2;var copyright=$('#copyright');copyright.css({'top':app.height+'px','opacity':1});copyright.show();var pcboard=$('#pc-board');pcboard.find('.qrcode div').html('<img src=\"http://plus.94uv.com/qrcode/urlQrcode.html?data='+decodeURIComponent(location.href)+'\"/>');pcboard.css({left:left+'px'}).show();app.initPager();};app.initPager=function(){var pager=$('#pc-board .pager a');var pPrev=$('#btn-prev');var pNext=$('#btn-next');pager.show();var slideCount=app.swiper.slides.length;pNext.on('click',function(){app.swiper.slideNext();return false;});pPrev.on('click',function(){app.swiper.slidePrev();return false;});var adjustPagers=function(){if(app.loop){return false;}
var curIndex=app.swiper.activeIndex;pager.css('visibility','visible');if(curIndex>=slideCount-1){pNext.css('visibility','hidden');}
else if(curIndex==0){pPrev.css('visibility','hidden');}
else{pager.show();}};app.swiper.on('SlideChangeEnd',adjustPagers);adjustPagers();};var loading=(function(){var allcount;var startTime;var loadedCount=0;var loadImgs=[];var isForcetime;var forceTime=1000;var callbackFn=function(){};function init(selector,readycallback,forcetime){if(forcetime){isForcetime=1;}
if(typeof readycallback=='function'){callbackFn=readycallback;}
var imgMap={};$(selector).each(function(i){var page=$(this);page.find('img').each(function(){var url=this.src;if(imgMap[url]){return;}
imgMap[url]=1;loadImgs.push(url);});var bgimg=page.css('background-image');if(bgimg=='none'||imgMap[bgimg]){return;}
imgMap[bgimg]=1;bgimg=bgimg.replace(/(\'|\")/g,'').replace('url(','').replace(')','');console.log('pre-image:'+bgimg);loadImgs.push(bgimg);});allcount=loadImgs.length;startTime=new Date();start();check();}
function start(){$.each(loadImgs,function(i,imgurl){var img=new Image();img.src=imgurl;img.onload=function(){if(this.complete){loadedCount++;updatePercent(Math.round(loadedCount/allcount*100));}};});}
var percentText=$('#percentage');function updatePercent(value){if(!percentText.length){return;}
percentText.text(value+'%');}
function check(){var nowTime=new Date();var gap=nowTime-startTime;if(isForcetime){if(loadedCount>=allcount&&gap>forceTime){callbackFn();}
else{setTimeout(function(){check();},200);}}
else{if(loadedCount>=allcount){callbackFn();}
else{setTimeout(function(){check();},200);}}}
return{init:init};})();function checkIsPC(){var system={win:false,mac:false,xll:false};var p=navigator.platform;system.win=p.indexOf('Win')==0;system.mac=p.indexOf('Mac')==0;system.x11=(p=='X11')||(p.indexOf('Linux')==0);var winWidth=$(window).width();if(winWidth>app.DEFAULT_WIDTH&&(system.win||system.mac||system.xll)){return true;}
else{return false;}}
app.music=(function(){var exports=$({});var music=$('audio')[0];var PAUSE_CLASS='player-btn-stop';exports.init=function(){$('.player-btn').on('click',function(){var _me=$(this);if(_me.hasClass('player-btn-stop')){exports.on();}
else{exports.off();}});};exports.on=function(){$('.player-btn').removeClass(PAUSE_CLASS);music.play();};exports.off=function(){$('.player-btn').addClass(PAUSE_CLASS);music.pause();};return exports;})();