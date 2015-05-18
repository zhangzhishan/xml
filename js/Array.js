Array.prototype.each = function(f,r){//(function,reverse) reverse=-1 retu rn
	if(r===-1){
		for(var i=this.length-1;i>=0;i--)f(this[i],i);
	}else{
		for(var i=0,l=this.length;i<l;i++)f(this[i],i);
	}
};
Array.prototype.indexOf = function(v,b){//Simple
    var idx=-1;
	if(b===true && typeof(v)=="function"){//b:true
		for (var i=0,l=this.length;i<l;i++) {
			if(v(this[i])){idx=i; break;}
		}
	} else {
		for (var i=0,l=this.length;i<l;i++) {
			if(this[i]===v){idx=i; break;}
		}
	}
	return idx;
};
Array.prototype.lastIndexOf = function(v,b){//
    var idx=-1;
	if(b===true && typeof(v)=="function"){//b:true,
		for (var i=this.length-1;i>=0;i--) {
			if(v(this[i])){idx=i; break;}
		}
	} else {
		for (var i=this.length-1;i>=0;i--) {
			if(this[i]===v){idx=i; break;}
		}
	}
	return idx;
};
Array.prototype.remove	= function(f){//
	var ME=this;
	if(typeof(f)=="function"){
		ME.each(function(s,i){
			if(f(s,i))ME.splice(i,1);
		},-1);
	}
	return ME;
};
