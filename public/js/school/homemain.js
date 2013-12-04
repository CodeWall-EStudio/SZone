var schoolObj = {};
;(function() {
  'use strict';

  requirejs.config({
    baseUrl: '/js/school',
    paths: {
      jquery: '/js/lib/jquery/jquery-1.9.1.min'
    }
    /*,
    shim: {
      jqui: {
        deps: ['jquery']
      },
      jqext : {
        deps : ['jquery']
      },
      jqjson : {
        deps : ['jquery']
      }      
    }
    */
  });
  //main
  require(['view.my'], function(view) {
    var handlerObj = $(schoolObj);

    handlerObj.triggerHandler('myspace:init',1);
  });

})();
