/* Make it safe to use console.log always */
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});

(function(){
    var cdnJquery   = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',
        localJquery = 'javascripts/libs/jquery-1.6.4.min.js',
        localLess   = 'javascripts/libs/less-1.1.3.min.js';
    
    console.log(Modernizr);

    Modernizr.load([
        {
            load: localLess,
            complete: function() {
                less.env = 'development';
                less.watch();
            } 
        },
        {
            load: cdnJquery,
            complete: function() {
                if ( !window.jQuery ) { 
                    Modernizr.load( localJquery ); 
                }
            }
        }
    ]);

}());