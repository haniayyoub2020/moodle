define("core/sessionstorage",["core/config","core/storagewrapper"],function(a,b){var c=new b(window.sessionStorage);return{get:function b(a){return c.get(a)},set:function d(a,b){return c.set(a,b)}}});
//# sourceMappingURL=sessionstorage.es6.js.map
