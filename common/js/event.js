gsap.registerPlugin(ScrollTrigger)
let container = document.getElementById("scroll-content");
console.log(container);




var div1 = document.getElementsByClassName('naviBtn')[0];
var div2 = document.getElementsByClassName('siteNavi hide')[0];
var div3 = document.getElementsByClassName('siteNavi_pages hide')[0];
var div4 = document.getElementsByClassName('siteNavi_links hide')[0];
var div5 = document.getElementsByClassName('closeBtn siteNavi_closeBtn hide')[0];
var div6 = document.getElementsByClassName('siteNavi_links hide')[0];

var div7 = document.getElementsByClassName('siteNavi_bg')[0];
var div8 = document.getElementsByClassName('closeBtn_area')[0];

// set an event listener for it
div1.addEventListener('click',function(){
  div1.setAttribute("class", "naviBtn hide");
  div2.setAttribute("class", "siteNavi");
  div3.setAttribute("class", "siteNavi_pages");
  div4.setAttribute("class", "siteNavi_links");
  div5.setAttribute("class", "closeBtn siteNavi_closeBtn");
  div6.setAttribute("class", "siteNavi_links");
  div7.setAttribute("class", "siteNavi_bg open");

});

div8.addEventListener('click',function(){

  div1.setAttribute("class", "naviBtn"







);
  div2.setAttribute("class", "siteNavi hide");
  div3.setAttribute("class", "siteNavi_pages hide");
  div4.setAttribute("class", "siteNavi_links hide");
  div5.setAttribute("class", "closeBtn siteNavi_closeBtn hide");
  div6.setAttribute("class", "siteNavi_links hide");
  div7.setAttribute("class", "siteNavi_bg");
  div8.setAttribute("class", "closeBtn_area");


});


ScrollTrigger.matchMedia({

  // large
  "(min-width: 1024px)": function() {
    gsap.to(container, {
      x: () => -(container.scrollWidth - document.documentElement.clientWidth) + "px",
      ease: "none",
      scrollTrigger: {
        trigger: container,
        invalidateOnRefresh: true,
        pin: true,
        scrub: 1,
        end: () => "+=" + (container.offsetWidth * 4)
      }
    })

  }});
