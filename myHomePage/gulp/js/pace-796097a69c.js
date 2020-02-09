(function(){var t,e,n,r,s,o,i,a,u,c,l,p,h,f,d,g,m,y,w,v,P,b,S,k,q,x,L,R,T,E,C,N,j,M,O,_,A,F,U,W,X,B,I,D,H,z,G,J=[].slice,K={}.hasOwnProperty,Q=function(t,e){function n(){this.constructor=t}for(var r in e)K.call(e,r)&&(t[r]=e[r]);return n.prototype=e.prototype,t.prototype=new n,t.__super__=e.prototype,t},V=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++)if(e in this&&this[e]===t)return e;return-1};for(v={catchupTime:500,initialRate:.03,minTime:500,ghostTime:500,maxProgressPerFrame:10,easeFactor:1.25,startOnPageLoad:!0,restartOnPushState:!0,restartOnRequestAfter:500,target:"body",elements:{checkInterval:100,selectors:["body"]},eventLag:{minSamples:10,sampleCount:3,lagThreshold:3},ajax:{trackMethods:["GET"],trackWebSockets:!0,ignoreURLs:[]}},R=function(){var t;return null!=(t="undefined"!=typeof performance&&null!==performance&&"function"==typeof performance.now?performance.now():void 0)?t:+new Date},E=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame,w=window.cancelAnimationFrame||window.mozCancelAnimationFrame,null==E&&(E=function(t){return setTimeout(t,50)},w=function(t){return clearTimeout(t)}),N=function(t){var e,n;return e=R(),(n=function(){var r;return(r=R()-e)>=33?(e=R(),t(r,function(){return E(n)})):setTimeout(n,33-r)})()},C=function(){var t,e,n;return n=arguments[0],e=arguments[1],t=3<=arguments.length?J.call(arguments,2):[],"function"==typeof n[e]?n[e].apply(n,t):n[e]},P=function(){var t,e,n,r,s,o,i;for(e=arguments[0],o=0,i=(r=2<=arguments.length?J.call(arguments,1):[]).length;o<i;o++)if(n=r[o])for(t in n)K.call(n,t)&&(s=n[t],null!=e[t]&&"object"==typeof e[t]&&null!=s&&"object"==typeof s?P(e[t],s):e[t]=s);return e},g=function(t){var e,n,r,s,o;for(n=e=0,s=0,o=t.length;s<o;s++)r=t[s],n+=Math.abs(r),e++;return n/e},S=function(t,e){var n,r,s;if(null==t&&(t="options"),null==e&&(e=!0),s=document.querySelector("[data-pace-"+t+"]")){if(n=s.getAttribute("data-pace-"+t),!e)return n;try{return JSON.parse(n)}catch(t){return r=t,"undefined"!=typeof console&&null!==console?console.error("Error parsing inline pace options",r):void 0}}},i=function(){function t(){}return t.prototype.on=function(t,e,n,r){var s;return null==r&&(r=!1),null==this.bindings&&(this.bindings={}),null==(s=this.bindings)[t]&&(s[t]=[]),this.bindings[t].push({handler:e,ctx:n,once:r})},t.prototype.once=function(t,e,n){return this.on(t,e,n,!0)},t.prototype.off=function(t,e){var n,r,s;if(null!=(null!=(r=this.bindings)?r[t]:void 0)){if(null==e)return delete this.bindings[t];for(n=0,s=[];n<this.bindings[t].length;)this.bindings[t][n].handler===e?s.push(this.bindings[t].splice(n,1)):s.push(n++);return s}},t.prototype.trigger=function(){var t,e,n,r,s,o,i,a,u;if(n=arguments[0],t=2<=arguments.length?J.call(arguments,1):[],null!=(i=this.bindings)?i[n]:void 0){for(s=0,u=[];s<this.bindings[n].length;)r=(a=this.bindings[n][s]).handler,e=a.ctx,o=a.once,r.apply(null!=e?e:this,t),o?u.push(this.bindings[n].splice(s,1)):u.push(s++);return u}},t}(),null==window.Pace&&(window.Pace={}),P(Pace,i.prototype),T=Pace.options=P({},v,window.paceOptions,S()),B=0,D=(z=["ajax","document","eventLag","elements"]).length;B<D;B++)!0===T[_=z[B]]&&(T[_]=v[_]);u=function(t){function e(){return e.__super__.constructor.apply(this,arguments)}return Q(e,t),e}(Error),e=function(){function t(){this.progress=0}return t.prototype.getElement=function(){var t;if(null==this.el){if(!(t=document.querySelector(T.target)))throw new u;this.el=document.createElement("div"),this.el.className="pace pace-active",this.el.style.display="none",null!=t.firstChild?t.insertBefore(this.el,t.firstChild):t.appendChild(this.el)}return this.el},t.prototype.finish=function(){var t;return t=this.getElement(),t.className=t.className.replace("pace-active",""),t.className+=" pace-inactive",document.body.className=document.body.className.replace("pace-running",""),document.body.className+=" pace-done"},t.prototype.update=function(t){return this.progress=t,this.render()},t.prototype.destroy=function(){try{this.getElement().parentNode.removeChild(this.getElement())}catch(t){u=t}return this.el=void 0},t.prototype.render=function(){var t=0,e=document.getElementsByClassName("load")[0],n=document.getElementsByClassName("load")[0].getElementsByTagName("p")[0],r=document.getElementsByClassName("pace")[0];return null!=document.querySelector(T.target)&&(this.getElement(),(!this.lastRenderedProgress||this.lastRenderedProgress|0!==this.progress|0)&&(this.progress>=100?"99":(this.progress<10?"0":"",0|this.progress)),t=parseInt(this.progress),n.innerText=t+"%",100==t&&(e.style.display="none",document.body.removeChild(r)),this.lastRenderedProgress=this.progress)},t.prototype.done=function(){return this.progress>=100},t}(),a=function(){function t(){this.bindings={}}return t.prototype.trigger=function(t,e){var n,r,s,o,i;if(null!=this.bindings[t]){for(i=[],r=0,s=(o=this.bindings[t]).length;r<s;r++)n=o[r],i.push(n.call(this,e));return i}},t.prototype.on=function(t,e){var n;return null==(n=this.bindings)[t]&&(n[t]=[]),this.bindings[t].push(e)},t}(),X=window.XMLHttpRequest,W=window.XDomainRequest,U=window.WebSocket,b=function(t,e){var n,r,s;s=[];for(n in e.prototype)try{r=e.prototype[n],null==t[n]&&"function"!=typeof r?s.push(t[n]=r):s.push(void 0)}catch(t){t}return s},x=[],Pace.ignore=function(){var t,e,n;return e=arguments[0],t=2<=arguments.length?J.call(arguments,1):[],x.unshift("ignore"),n=e.apply(null,t),x.shift(),n},Pace.track=function(){var t,e,n;return e=arguments[0],t=2<=arguments.length?J.call(arguments,1):[],x.unshift("track"),n=e.apply(null,t),x.shift(),n},O=function(t){var e;if(null==t&&(t="GET"),"track"===x[0])return"force";if(!x.length&&T.ajax){if("socket"===t&&T.ajax.trackWebSockets)return!0;if(e=t.toUpperCase(),V.call(T.ajax.trackMethods,e)>=0)return!0}return!1},c=function(t){function e(){var t,n=this;e.__super__.constructor.apply(this,arguments),t=function(t){var e;return e=t.open,t.open=function(r,s,o){return O(r)&&n.trigger("request",{type:r,url:s,request:t}),e.apply(t,arguments)}},window.XMLHttpRequest=function(e){var n;return n=new X(e),t(n),n};try{b(window.XMLHttpRequest,X)}catch(t){}if(null!=W){window.XDomainRequest=function(){var e;return e=new W,t(e),e};try{b(window.XDomainRequest,W)}catch(t){}}if(null!=U&&T.ajax.trackWebSockets){window.WebSocket=function(t,e){var r;return r=null!=e?new U(t,e):new U(t),O("socket")&&n.trigger("request",{type:"socket",url:t,protocols:e,request:r}),r};try{b(window.WebSocket,U)}catch(t){}}}return Q(e,a),e}(),I=null,M=function(t){var e,n,r,s;for(n=0,r=(s=T.ajax.ignoreURLs).length;n<r;n++)if("string"==typeof(e=s[n])){if(-1!==t.indexOf(e))return!0}else if(e.test(t))return!0;return!1},(k=function(){return null==I&&(I=new c),I})().on("request",function(e){var n,r,s,o,i;if(o=e.type,s=e.request,i=e.url,!M(i))return Pace.running||!1===T.restartOnRequestAfter&&"force"!==O(o)?void 0:(r=arguments,"boolean"==typeof(n=T.restartOnRequestAfter||0)&&(n=0),setTimeout(function(){var e,n,i,a,u;if("socket"===o?s.readyState<2:0<(i=s.readyState)&&i<4){for(Pace.restart(),u=[],e=0,n=(a=Pace.sources).length;e<n;e++){if((_=a[e])instanceof t){_.watch.apply(_,r);break}u.push(void 0)}return u}},n))}),t=function(){function t(){var t=this;this.elements=[],k().on("request",function(){return t.watch.apply(t,arguments)})}return t.prototype.watch=function(t){var e,n,r,s;if(r=t.type,e=t.request,s=t.url,!M(s))return n="socket"===r?new h(e):new f(e),this.elements.push(n)},t}(),f=function(){return function(t){var e,n,r,s,o,i=this;if(this.progress=0,null!=window.ProgressEvent)for(t.addEventListener("progress",function(t){return t.lengthComputable?i.progress=100*t.loaded/t.total:i.progress=i.progress+(100-i.progress)/2}),n=0,r=(o=["load","abort","timeout","error"]).length;n<r;n++)e=o[n],t.addEventListener(e,function(){return i.progress=100});else s=t.onreadystatechange,t.onreadystatechange=function(){var e;return 0===(e=t.readyState)||4===e?i.progress=100:3===t.readyState&&(i.progress=50),"function"==typeof s?s.apply(null,arguments):void 0}}}(),h=function(){return function(t){var e,n,r,s,o=this;for(this.progress=0,n=0,r=(s=["error","open"]).length;n<r;n++)e=s[n],t.addEventListener(e,function(){return o.progress=100})}}(),r=function(){return function(t){var e,n,r,o;for(null==t&&(t={}),this.elements=[],null==t.selectors&&(t.selectors=[]),n=0,r=(o=t.selectors).length;n<r;n++)e=o[n],this.elements.push(new s(e))}}(),s=function(){function t(t){this.selector=t,this.progress=0,this.check()}return t.prototype.check=function(){var t=this;return document.querySelector(this.selector)?this.done():setTimeout(function(){return t.check()},T.elements.checkInterval)},t.prototype.done=function(){return this.progress=100},t}(),n=function(){function t(){var t,e,n=this;this.progress=null!=(e=this.states[document.readyState])?e:100,t=document.onreadystatechange,document.onreadystatechange=function(){return null!=n.states[document.readyState]&&(n.progress=n.states[document.readyState]),"function"==typeof t?t.apply(null,arguments):void 0}}return t.prototype.states={loading:0,interactive:50,complete:100},t}(),o=function(){return function(){var t,e,n,r,s,o=this;this.progress=0,t=0,s=[],r=0,n=R(),e=setInterval(function(){var i;return i=R()-n-50,n=R(),s.push(i),s.length>T.eventLag.sampleCount&&s.shift(),t=g(s),++r>=T.eventLag.minSamples&&t<T.eventLag.lagThreshold?(o.progress=100,clearInterval(e)):o.progress=3/(t+3)*100},50)}}(),p=function(){function t(t){this.source=t,this.last=this.sinceLastUpdate=0,this.rate=T.initialRate,this.catchup=0,this.progress=this.lastProgress=0,null!=this.source&&(this.progress=C(this.source,"progress"))}return t.prototype.tick=function(t,e){var n;return null==e&&(e=C(this.source,"progress")),e>=100&&(this.done=!0),e===this.last?this.sinceLastUpdate+=t:(this.sinceLastUpdate&&(this.rate=(e-this.last)/this.sinceLastUpdate),this.catchup=(e-this.progress)/T.catchupTime,this.sinceLastUpdate=0,this.last=e),e>this.progress&&(this.progress+=this.catchup*t),n=1-Math.pow(this.progress/100,T.easeFactor),this.progress+=n*this.rate*t,this.progress=Math.min(this.lastProgress+T.maxProgressPerFrame,this.progress),this.progress=Math.max(0,this.progress),this.progress=Math.min(100,this.progress),this.lastProgress=this.progress,this.progress},t}(),A=null,j=null,m=null,F=null,d=null,y=null,Pace.running=!1,q=function(){if(T.restartOnPushState)return Pace.restart()},null!=window.history.pushState&&(H=window.history.pushState,window.history.pushState=function(){return q(),H.apply(window.history,arguments)}),null!=window.history.replaceState&&(G=window.history.replaceState,window.history.replaceState=function(){return q(),G.apply(window.history,arguments)}),l={ajax:t,elements:r,document:n,eventLag:o},(L=function(){var t,n,r,s,o,i,a,u;for(Pace.sources=A=[],n=0,s=(i=["ajax","elements","document","eventLag"]).length;n<s;n++)!1!==T[t=i[n]]&&A.push(new l[t](T[t]));for(r=0,o=(u=null!=(a=T.extraSources)?a:[]).length;r<o;r++)_=u[r],A.push(new _(T));return Pace.bar=m=new e,j=[],F=new p})(),Pace.stop=function(){return Pace.trigger("stop"),Pace.running=!1,m.destroy(),y=!0,null!=d&&("function"==typeof w&&w(d),d=null),L()},Pace.restart=function(){return Pace.trigger("restart"),Pace.stop(),Pace.start()},Pace.go=function(){var t;return Pace.running=!0,m.render(),t=R(),y=!1,d=N(function(e,n){var r,s,o,i,a,u,c,l,h,f,d,g,w,v,P;for(100-m.progress,s=f=0,o=!0,u=d=0,w=A.length;d<w;u=++d)for(_=A[u],h=null!=j[u]?j[u]:j[u]=[],c=g=0,v=(a=null!=(P=_.elements)?P:[_]).length;g<v;c=++g)i=a[c],o&=(l=null!=h[c]?h[c]:h[c]=new p(i)).done,l.done||(s++,f+=l.tick(e));return r=f/s,m.update(F.tick(e,r)),m.done()||o||y?(m.update(100),Pace.trigger("done"),setTimeout(function(){return m.finish(),Pace.running=!1,Pace.trigger("hide")},Math.max(T.ghostTime,Math.max(T.minTime-(R()-t),0)))):n()})},Pace.start=function(t){P(T,t),Pace.running=!0;try{m.render()}catch(t){u=t}return document.querySelector(".pace")?(Pace.trigger("start"),Pace.go()):setTimeout(Pace.start,50)},"function"==typeof define&&define.amd?define(function(){return Pace}):"object"==typeof exports?module.exports=Pace:T.startOnPageLoad&&Pace.start()}).call(this);