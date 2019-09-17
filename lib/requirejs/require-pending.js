(() => {
    window.require = (...arguments) => {
        M.util.js_pending('requirejsinit');
        window.requirejs.apply(this, arguments);
        M.util.js_complete('requirejsinit');
    };
})();
