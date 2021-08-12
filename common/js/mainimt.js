const scroller = new LocomotiveScroll({
  el: document.querySelector("[data-scroll-container]"),
  smooth: true
})

$(document).ready(function () {

/*Cursor*/
    var cursor = {


    init: function () {
        // Set up element sizes
        this.dotSize = this.$dot.offsetWidth;
        this.outlineSize = this.$outline.offsetWidth;

        this.setupEventListeners();
        this.animateDotOutline();
    },








};


  /*Animation Load*/

  /*Preload Images*/
  if (typeof preloadImageList !== "undefined") {
    if (preloadImageList.length > 0) {
      checkImagesLoaded(preloadImageList)
    } else {
      whenImagesAreLoaded(0)
    }
  } else {
    whenImagesAreLoaded(0)
  }

  function checkImagesLoaded(arrayIds) {
    // Initialize the counter
    var counter = arrayIds.length

    arrayIds.forEach(function (id) {
      var element = $("#" + id)
      if (!element.prop("complete")) {
        element.on("load", function () {
          counter--
          whenImagesAreLoaded(counter)
        })
        element.on("error", function () {
          counter--
          whenImagesAreLoaded(counter)
        })
      } else {
        counter--
        whenImagesAreLoaded(counter)
      }
    })
  }

  function whenImagesAreLoaded(counter) {
    if (counter === 0) {
      setTimeout(function () {
        $(".content_loading").addClass("load")
      }, 200)

      setTimeout(function () {
        /*Lottie Init*/
        var loader_b = document.getElementsByClassName("w_animation")
        function loadBMAnimation_b_animation(loader_b) {
          var animation = bodymovin.loadAnimation({
            container: loader_b,
            renderer: "svg",
            loop: false,
            autoplay: true,
            path: "lottie/w.json"
          })
        }
        for (var i = 0; i < loader_b.length; i++) {
          loadBMAnimation_b_animation(loader_b[i])
        }
        /*Show*/
        $(".gh, .content_navigation").addClass("show")
      }, 200)

      setTimeout(function () {
        $(".content_about").addClass("active")
      }, 500)
    }
  }

    scroller.on("call", scrollToLastSection)
})


/*const scrollToLastSection = function (obj) {

  const bodyClass = "active"

  if (obj == "contactus") {
    document.querySelector(".content_navigation").classList.add(bodyClass)
    console.log(obj)
  } else {
    document.querySelector(".content_navigation").classList.remove(bodyClass)
    console.log(obj)

  }
}*/

const scrollToLastSection = function (obj, action) {
  const bodyClass = "active"

  if (obj == "contactus") {
    if(action == "enter"){
      document.querySelector(".content_navigation").classList.add(bodyClass)
    }else{
      document.querySelector(".content_navigation").classList.remove(bodyClass)
    }

  }
}

/*Reset Form*/
$('#reset').click(function() {
    $(':input','#frmContact')
        .not(':button, :submit, :reset, :hidden')
        .val('')
        .removeAttr('checked')
        .removeAttr('selected');
    $('.content_contact').removeClass('success');
});

var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 35 - Math.random() * 2;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };
