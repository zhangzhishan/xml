var lDOM ={
	BV	 :(function(){
		var u="indexOf",
			n=navigator,
			a= n.userAgent.toLowerCase(),
			b= (document.getElementById?true:false),
			c= ((a[u]("msie")!=-1) && (a[u]("opera")==-1) && (a[u]("omniweb")==-1)),
			d= b && (n.appName=="Netscape"),
			e= a[u]("opera")!= -1,
			f = a[u]("gecko") != -1;
			return {AGT:a,isW3C:b,isIE:c,isFF:d,isNS6:d,isOP:e,isGecko:f};
		})(),
	$	: function(s){
		var o = typeof(s)=="string"?document.getElementById(s):s;
		try{return o;} finally {o=null;}
	},
	hasClass: function(e,c){
		if (!(e = this.$(e))) return false;
		e = e.className || " ";
		e = " " + e + " ";
		c = " " + c + " ";
		return (e.indexOf(c)!=-1);
	},
	addClass: function(e,c){
		if (!(e = this.$(e))) return;
		if (this.hasClass(e,c)){return;}
		e.className=e.className+" "+c;
	},
	delClass: function(e,c){//(element,className)
		if(this.hasClass(e,c)){
			e = this.$(e);
			var a=e.className.split(" ");
			a.remove(function(s){
				return s==c;
			});
			e.className=a.join(" ");
		}
	},
	each	: function(a,b,f,t){//(tagPath,parentNode,callFunction,tagPathType)
		//Rely on: this.hasAttr()
		if (!(b = this.$(b))) b=document.body;
		if(!b.length)b=[b];
		a=(function(p){//Format
			if(typeof(p)!="string") return [];
			//p=p.tirm();
			p=p.replace(/\s+/g," ").split(" ");
			var r=[],ns=0,ne=0;
			p.each(function(s,i){//Format
				var n=s.indexOf(".");
				if(n>-1){
					if(n==0)s="*"+s;
				} else {
					s=s+".*";
				}
				s=s.split(".");
				var t=s[0].toUpperCase(),c=s[1];
				p[i]=[t,c];
			});
			p.each(function(s,i){
				var m=r.indexOf(function(x,k){
						return s[0]==x[0];
					},true);
					if(m>-1){
						r[m][2]+=1;
						r[m][1].push(s[1]);
					} else {
						r.push([s[0],[s[1]],1]);
					}
			},-1);
			r.reverse();
			a=null;
			r.each(function(s,i){//
				ne=p.lastIndexOf(function(x){
					return x[0]==s[0];
				},true)+1;
				s[2]=0;
				p.slice(ns,ne).each(function(y){//slice
					if(y[0]==s[0])s[2]+=1;
				});
				ns=ne;
			});
			r.each(function(s){//className
				s[1]=s[1].slice(0,s[2]);
			});
			return r;})(a);
			var ME=this,r=[];

			function AR(a,f,d){//arraryRun(array,function,direction);
				if(d===-1){
					for(var i=a.length-1; i>=0;i--){
						f(a[i],i);
					}
				} else {
					for(var i=0,l=a.length; i<l;i++){
						f(a[i],i);
					}
				}
			}

			function $N(sp,t,p){//isOKPNode(subNode,tagInfo,pNode)
				var o=sp,tn=t[0],cls=t[1],cnt=t[2],n=0,b=false;
				if(tn=="*")tn=o.tagName;
				while(o!=p && n<cnt){
					if(o.tagName==tn){
						if(cls[n]!="*"){
							if(ME.hasClass(o,cls[n]))n+=1;
						} else {
							n+=1;
						}
					}
					o=o.parentNode;
				}
				if(n==cnt){
					b=true;
					while(o!=p && b){
						if(o.tagName==tn){
							b=false;
						}
						o=o.parentNode;
					}
				}
				//alert(b+":"+tn+":"+cnt+":"+n);
				return b;
			}
			function $C(sp,t,p){//isOKPNode(subNode,tagInfo,pNode)
				var o=sp,tn=t[0],cls=t[1],cnt=t[2],n=0;//,b=false;
				if(tn=="*")tn=o.tagName;
				while(o!=p && n<cnt){
					if(o.tagName==tn){
						if(cls[n]!="*"){
							if(ME.hasClass(o,cls[n])){
								n+=1;
							}
						} else {
								n+=1;
						}
					}
					o=o.parentNode;
				}
				//b=(n==cnt);
				//return b;
				return n==cnt;
			}

			function $F(t,p,f){//choseNodes(tagInfo,arrParent,isLastLevel,callFunc)
				var tn=t[0],R=[];
				AR(p,function(o,i){
					var nodes=o.getElementsByTagName(tn);
					AR(nodes,function(c,j){
							if(f(c,t,o)){
								R.push(c);
							}
					});
				});
				//alert(tn+":"+R.length);
				return R;
			}

			function $L(t,p,f,b){//choseNodes(tagInfo,arrParent,callFunc,choseMode)
				var cm=(b===true?$N:$C);
				if(typeof(f)=="function"){
					var tn=t[0],R=[];
					AR(p,function(o,i){
						var nodes=o.getElementsByTagName(tn);
						AR(nodes,function(c,j){
								if(cm(c,t,o)){
									if(f(c,R.length)){
										R.push(c);
									}
								}
						});
					});
					return R;
				} else {
					return $F(t,p,cm);
				}
			}
			function $A(t,p,f,m){//choseAllNodes(tagAllInfo,arrParent,callFunc,choseMode)
				var l=t.length-1;
				AR(t,function(s,i){
					if(i>=l){
						p=$L(s,p,f,m);
					} else {
						p=$F(s,p,$N);
					}
				});
				return p;
			}
			r=$A(a,b,f,t);
			return r;
	},
	find	: function(a,p,A,t){//(tagPath,parent,attr,tagPathType)
		var ME=this,R=[];
		if(typeof(A)=="object"){
			var f	= function(x,i){
				return ME.hasAttr(x,A);
			};
			R=ME.each(a,p,f,t);
		} else {
			R=ME.each(a,p,null,t);
		}
		return R;
	},
	fixAttr:function (){
		return{
			"for": "htmlFor",
			"class": "className",
			"float": this.BV.isIE ? "styleFloat" : "cssFloat",
			cssFloat: this.BV.isIE ? "styleFloat" : "cssFloat",
			innerHTML: "innerHTML",
			className: "className",
			value: "value",
			disabled: "disabled",
			checked: "checked",
			readonly: "readOnly",
			selected: "selected",
			tagName	: "tagName"
		};
	},
	hasAttr	: function(o,a){//hasAttribs(object,attribs)
		var b = true;
		var fix = this.fixAttr(),r;
		for (var x in a){
			if (fix[x]){
				r=o[fix[x]];
			} else{
				//r=o[x];
				r=o.getAttribute(x);
			}
			if(typeof(a[x])=="function"){
				if(!a[x](r)){b=false;break;}
			} else {
				if(r!=a[x]){b=false;break;}
			}
		}
		return b;
	},
	setAttr : function (e,a){//setAttribs(element,attribs)
		for (var x in a){
			e[x] = a[x];
		}
	},
	setStyle : function (e,s){//setStyle(element,styles)
		this.setAttr(e["style"],s);
	},
	CE	: function (t,a,s,p,w){//createElement(tagName,attribs,styles,parentNode,where)
		//w = w===0?0:-1;
		var el = document.createElement(t);
		if (p)w===0?p.insertBefore(el,p.firstChild):p.appendChild(el);
		if (a) this.setAttr(el, a);
		if (s) this.setStyle(el, s);
		try{return el;} finally {el=null;}
	}
};
