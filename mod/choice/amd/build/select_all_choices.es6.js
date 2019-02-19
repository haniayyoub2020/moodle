define("mod_choice/select_all_choices",["jquery"],function(a){return{init:function b(){a(".selectallnone a").on("click",function(b){b.preventDefault();a("#attemptsform").find("input:checkbox").prop("checked",a(this).data("selectInfo"))})}}});
//# sourceMappingURL=select_all_choices.es6.js.map
