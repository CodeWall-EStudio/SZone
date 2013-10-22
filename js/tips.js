;(function(root){

	console.log(root);
	root.widget = (function(){

		function prog(text){
			if(!$("#progTips").length){
				$('<div id="progTips" class="prog-tips hide"><div class="progress"><div class="progress-bar" ></div><span></span></div><div class="prog-txt">正在上传</div></div>').appendTo($('body'));
			}else{
				$("#progTips .prog-text").text(text);
			}
		}

		prog.prototype.show = function(){
			$("#progTips").removeClass('hide');
		}

		prog.prototype.hide = function(){
			$("#progTips").addClass('hide');
		}

		prog.prototype.setProg = function(num){
			$("#progTips .progress-bar").css('width',num+'%');
			$('#progTips span').text(num+'%');
		}

		return {
			prog : prog
		}
	})();


})(window.szone);