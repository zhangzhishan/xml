var lTREE = function(){
	var ME=this;
	this.onclick	=null;
	this.config={
		path	: "ul li",
		classClosed: "Closed",
		func	: null,
		mode	: false,
		openAll:false
	};
	//if(lDOM.isIE)document.execCommand("BackgroundImageCache", false, true);
};

lTREE.prototype	= {
	click	 : function(o){
		o=o.parentNode;
		var a=this.config,c=a.classClosed,b=lDOM.hasClass(o,c);
		if(!b){
			lDOM.addClass(o,c);
		} else {
			lDOM.delClass(o,c);
		}
		if(typeof(this.onclick)=="function"){
			this.onclick(o,b);
		}
		return b;
	},
	set	: function(s){
		var ME=this,o=document.createElement("button");
		s.insertBefore(o,s.firstChild);
		o.onfocus=function(){
			ME.click(this);
			this.blur();
			return false;
		};
		o =null;
		return true;
	},
	setAll	: function(n){
		var c=this.config.classClosed;
		//var t=new Date();
		if(n>0){
			this.item.each(function(s){
				lDOM.delClass(s,c);
			});
		} else {
			this.item.each(function(s){
				lDOM.addClass(s,c);
			});
		}
	},
	init	: function(c){
		if (!lDOM.$(c.id)) return;
		var o=this.config;
		for(var x in c)o[x]=c[x];
		var ME=this,cn="s";
		var f=o.func;
		f=typeof(f)=="function"?f:function(x){ME.set(x);return true;};
		this.item=lDOM.each(o.path,lDOM.$(o.id),f,o.mode);
		if(o.openAll)this.setAll(1);
	}
};
