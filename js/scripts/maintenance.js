/*=========================================================================================
    File Name: page-coming-soon.js
    Description: Coming Soon
    ----------------------------------------------------------------------------------------
    Item name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

/*******************************
*       js of Countdown        *
********************************/

$(document).ready(function() {

  var todayDate = new Date();
  var releaseDate = new Date(todayDate.getFullYear(), todayDate.getMonth(), todayDate.getDate(), 6, 0, 0);


  /*$('#clockFlat').countdown(releaseDate).on('update.countdown', function(event) {
    var $this = $(this).html(event.strftime('<div class="clockCard px-1"> <span>%H</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Hour%!H </p> </div>'
      + '<div class="clockCard px-1"> <span>%M</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Minute%!M </p> </div>'
      + '<div class="clockCard px-1"> <span>%S</span> <br> <p class="bg-amber clockFormat lead px-1 black"> Second%!S </p> </div>'))
  });*/

    $('#fancyClock').stjClock();

});

(function($){

    // A global array used by the functions of the plug-in:
    var gVars = {};

    // Extending the jQuery core:
    $.fn.stjClock = function(opts){

        // "this" contains the elements that were selected when calling the plugin: $('elements').stjClock();
        // If the selector returned more than one element, use the first one:

        var container = this.eq(0);

        if(!container)
        {
            try{
                console.log("Invalid selector!");
            } catch(e){}

            return false;
        }

        if(!opts) opts = {};

        var defaults = {
            /* Additional options will be added in future versions of the plugin. */
        };

        /* Merging the provided options with the default ones (will be used in future versions of the plugin): */
        $.each(defaults,function(k,v){
            opts[k] = opts[k] || defaults[k];
        })

        // Calling the setUp function and passing the container,
        // will be available to the setUp function as "this":
        setUp.call(container);

        return this;
    }

    function setUp()
    {
        // The colors of the dials:
        var colors = ['orange','blue','green'];

        var tmp;

        for(var i=0;i<3;i++)
        {
            // Creating a new element and setting the color as a class name:

            tmp = $('<div>').attr('class',colors[i]+' clock').html(
                '<div class="display"></div>'+

                '<div class="front left"></div>'+

                '<div class="rotate left">'+
                '<div class="bg left"></div>'+
                '</div>'+

                '<div class="rotate right">'+
                '<div class="bg right"></div>'+
                '</div>'
            );

            // Appending to the container:
            $(this).append(tmp);

            // Assigning some of the elements as variables for speed:
            tmp.rotateLeft = tmp.find('.rotate.left');
            tmp.rotateRight = tmp.find('.rotate.right');
            tmp.display = tmp.find('.display');

            // Adding the dial as a global variable. Will be available as gVars.colorName
            gVars[colors[i]] = tmp;
        }

        // Setting up a interval, executed every 1000 milliseconds:
        setInterval(function(){

            var currentTime = new Date();
            var h = currentTime.getHours();
            var m = currentTime.getMinutes();
            var s = currentTime.getSeconds();

            animation(gVars.green, s, 60);
            animation(gVars.blue, m, 60);
            animation(gVars.orange, h, 24);

        },1000);
    }

    function animation(clock, current, total)
    {
        // Calculating the current angle:
        var angle = (360/total)*(current+1);

        var element;

        if(current==0)
        {
            // Hiding the right half of the background:
            clock.rotateRight.hide();

            // Resetting the rotation of the left part:
            rotateElement(clock.rotateLeft,0);
        }

        if(angle<=180)
        {
            // The left part is rotated, and the right is currently hidden:
            element = clock.rotateLeft;
        }
        else
        {
            // The first part of the rotation has completed, so we start rotating the right part:
            clock.rotateRight.show();
            clock.rotateLeft.show();

            rotateElement(clock.rotateLeft,180);

            element = clock.rotateRight;
            angle = angle-180;
        }

        rotateElement(element,angle);

        // Setting the text inside of the display element, inserting a leading zero if needed:
        clock.display.html(current<10?'0'+current:current);
    }

    function rotateElement(element,angle)
    {
        // Rotating the element, depending on the browser:
        var rotate = 'rotate('+angle+'deg)';

        if(element.css('MozTransform')!=undefined)
            element.css('MozTransform',rotate);

        else if(element.css('WebkitTransform')!=undefined)
            element.css('WebkitTransform',rotate);

        // A version for internet explorer using filters, works but is a bit buggy (no surprise here):
        else if(element.css("filter")!=undefined)
        {
            var cos = Math.cos(Math.PI * 2 / 360 * angle);
            var sin = Math.sin(Math.PI * 2 / 360 * angle);

            element.css("filter","progid:DXImageTransform.Microsoft.Matrix(M11="+cos+",M12=-"+sin+",M21="+sin+",M22="+cos+",SizingMethod='auto expand',FilterType='nearest neighbor')");

            element.css("left",-Math.floor((element.width()-200)/2));
            element.css("top",-Math.floor((element.height()-200)/2));
        }

    }

})(jQuery)
