define("core/localstorage",["core/config","core/storagewrapper"],function(a,b){var c=new b(window.localStorage);return{get:function b(a){return c.get(a)},set:function d(a,b){return c.set(a,b)}}});
//# sourceMappingURL=localstorage.es6.js.map
