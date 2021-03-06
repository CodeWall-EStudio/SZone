define(['util','templateManager'],function($u,$tm){
	var loop = function() {};

	var View = $u.newClass({	
		init : function(options){
			if(options){
				this.target = options.target || null;
				this.tplid = options.tplid;
				this.data = options.data || {};
				this.handlers = options.handlers || {};
				this.cgiurl = options.cgiurl || null;
				this.param = options.param;
				this.append = options.append || false;

				this.events = options.events || {};

				// 渲染模板前后调用的方法
				this.before = options.before || loop;
				this.after = options.after || loop;
			}
		},
		expand : function(options){
			this.target = options.target || this.target;
			this.tplid = options.tplid || this.tplid;
			this.data = options.data || this.data || {};
			$.extend(this.handlers,options.handlers || {});


			this.cgiurl = options.cgiurl || null;
			this.param = options.param;
			this.append = options.append || false;
		},
		createPanel : function(){
			this.before.call(this);

			var opts = {
				html : $u.encodeHTML,
				attr : $u.encodeAttr
			};
			if(this.data){
				$.extend(this.data,opts);

				renderPanel(this.target,this.tplid,this.data);
				bindHandlers(this.target,this.handlers, this.events);
			}

			this.after.call(this);
		},
		appendPanel : function(){
			this.before.call(this);

			var opts = {
				html : $u.encodeHTML,
				attr : $u.encodeAttr
			};
			if(this.data){
				$.extend(this.data,opts);
				appendPanel(this.target,this.tplid,this.data);
				bindHandlers(this.target,this.handlers, this.events);
			}

			this.after.call(this);
		},
		getHtml : function(){
			return getHtml(this.tplid,this.data);
		}
	});

	/*
	* 绑定事件
	*
	* @param  {object} target 目标节点
	* @param  {object} handlers 需绑定的事件
	* handlers 说明 
	* //直接绑定整个dom
	* {
	*	event : function
	* }
	* 列如 
	*{
	*	mousedown : function(){}
	*}
	* //绑定指定的dom 
	*{
	*	selecter : {
	*		event : function
	*	}
	*}
	*例如
	*{
	*	'#id' : {
	*		event : function(){}
	*	}
	*}
	*/
	function bindHandlers(target,handlers, events){
		for(var i in handlers){
			if(typeof handlers[i] === 'function'){
				target.off(i);
				target.bind(i,handlers[i]);
			}else{
				var handlerList = handlers[i];
				//target = $(i);
				//target.undelegate();
				for(var j in handlerList){
					target.undelegate(i,j);
					target.delegate(i,j,handlerList[j]);
				}
			}
		}

		for(var i in events){
			var handlerList = events[i];
			target = $(i);
			target.off();
			for(var j in handlerList){
				target.on(i,j,handlerList[j]);
			}
		}
	}

	/*
	* 填充模版
	* 
	* @param {object} target 目标节点
	* @param {string} tplid 模版id
	* @param {object} data 数据
	* handlers 说明 
	* //直接绑定整个dom
	* {
	*	event : function
	* }
	* 列如 
	*{
	*	mousedown : function(){}
	*}
	* //绑定指定的dom 
	*{
	*	selecter : {
	*		event : function
	*	}
	*}
	*例如
	*{
	*	'#id' : {
	*		event : function(){}
	*	}
	*}
	*/	
	function renderPanel(target,tplid,data, append){
		var template = $tm.get(tplid);
		var html = $u.template(template,data);

		if(append) return target.append(html);
		return target.html(html);
	}

	function appendPanel(target,tplid,data){
		var template = $tm.get(tplid);
		var html = $u.template(template,data);	
		return target.append(html);	
	}

	function getHtml(tplid,data){
		var template = $tm.get(tplid);
		var html = $u.template(template,data);	
		return html;
	}

	// added by jarvisjiang
	$.extend(View.prototype, {
		set target(target) {
			this.target = target;
		},
		set tplid(tplid) {
			this.tplid = tplid;
		},
		set data(data) {
			this.data = data;
		},
		set handlers(handlers) {
			this.handlers = handlers;
		},
		set append(append) {
			this.append = append;
		},
		set before(before) {
			this.before = before;
		},
		set after(after) {
			this.after = after || loop;
		}
	});

	return View;
});