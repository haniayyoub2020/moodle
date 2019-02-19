define("core/pubsub",[],function(){var a={};return{subscribe:function d(b,c){a[b]=a[b]||[];a[b].push(c)},unsubscribe:function e(b,c){if(a[b]){for(var d=0;d<a[b].length;d++){if(a[b][d]===c){a[b].splice(d,1);break}}}},publish:function d(b,c){if(a[b]){a[b].forEach(function(a){a(c)})}}}});
//# sourceMappingURL=pubsub.es6.js.map
