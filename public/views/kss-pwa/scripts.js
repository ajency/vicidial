!function(t,e){var n=function(t,e){"use strict";if(e.getElementsByClassName){var n,i,a=e.documentElement,r=t.Date,s=t.HTMLPictureElement,o="addEventListener",l="getAttribute",c=t[o],d=t.setTimeout,u=t.requestAnimationFrame||d,f=t.requestIdleCallback,m=/^picture$/i,z=["load","error","lazyincluded","_lazyloaded"],v={},y=Array.prototype.forEach,g=function(t,e){return v[e]||(v[e]=new RegExp("(\\s|^)"+e+"(\\s|$)")),v[e].test(t[l]("class")||"")&&v[e]},h=function(t,e){g(t,e)||t.setAttribute("class",(t[l]("class")||"").trim()+" "+e)},p=function(t,e){var n;(n=g(t,e))&&t.setAttribute("class",(t[l]("class")||"").replace(n," "))},C=function(t,e,n){var i=n?o:"removeEventListener";n&&C(t,e),z.forEach(function(n){t[i](n,e)})},b=function(t,i,a,r,s){var o=e.createEvent("Event");return a||(a={}),a.instance=n,o.initEvent(i,!r,!s),o.detail=a,t.dispatchEvent(o),o},A=function(e,n){var a;!s&&(a=t.picturefill||i.pf)?(n&&n.src&&!e[l]("srcset")&&e.setAttribute("srcset",n.src),a({reevaluate:!0,elements:[e]})):n&&n.src&&(e.src=n.src)},E=function(t,e){return(getComputedStyle(t,null)||{})[e]},w=function(t,e,n){for(n=n||t.offsetWidth;n<i.minSize&&e&&!t._lazysizesWidth;)n=e.offsetWidth,e=e.parentNode;return n},M=function(){var t,n,i=[],a=[],r=i,s=function(){var e=r;for(r=i.length?a:i,t=!0,n=!1;e.length;)e.shift()();t=!1},o=function(i,a){t&&!a?i.apply(this,arguments):(r.push(i),n||(n=!0,(e.hidden?d:u)(s)))};return o._lsFlush=s,o}(),N=function(t,e){return e?function(){M(t)}:function(){var e=this,n=arguments;M(function(){t.apply(e,n)})}},_=function(t){var e,n=0,a=i.throttleDelay,s=i.ricTimeout,o=function(){e=!1,n=r.now(),t()},l=f&&s>49?function(){f(o,{timeout:s}),s!==i.ricTimeout&&(s=i.ricTimeout)}:N(function(){d(o)},!0);return function(t){var i;(t=!0===t)&&(s=33),e||(e=!0,(i=a-(r.now()-n))<0&&(i=0),t||i<9?l():d(l,i))}},W=function(t){var e,n,i=function(){e=null,t()},a=function(){var t=r.now()-n;t<99?d(a,99-t):(f||i)(i)};return function(){n=r.now(),e||(e=d(a,99))}};!function(){var e,n={lazyClass:"lazyload",loadedClass:"lazyloaded",loadingClass:"lazyloading",preloadClass:"lazypreload",errorClass:"lazyerror",autosizesClass:"lazyautosizes",srcAttr:"data-src",srcsetAttr:"data-srcset",sizesAttr:"data-sizes",minSize:40,customMedia:{},init:!0,expFactor:1.5,hFac:.8,loadMode:2,loadHidden:!0,ricTimeout:0,throttleDelay:125};for(e in i=t.lazySizesConfig||t.lazysizesConfig||{},n)e in i||(i[e]=n[e]);t.lazySizesConfig=i,d(function(){i.init&&B()})}();var x=function(){var s,u,f,z,v,w,x,B,F,S,L,R,k,D,H=/^img$/i,O=/^iframe$/i,P="onscroll"in t&&!/(gle|ing)bot/.test(navigator.userAgent),$=0,I=0,q=-1,j=function(t){I--,t&&t.target&&C(t.target,j),(!t||I<0||!t.target)&&(I=0)},G=function(t,n){var i,r=t,s="hidden"==E(e.body,"visibility")||"hidden"!=E(t.parentNode,"visibility")&&"hidden"!=E(t,"visibility");for(B-=n,L+=n,F-=n,S+=n;s&&(r=r.offsetParent)&&r!=e.body&&r!=a;)(s=(E(r,"opacity")||1)>0)&&"visible"!=E(r,"overflow")&&(i=r.getBoundingClientRect(),s=S>i.left&&F<i.right&&L>i.top-1&&B<i.bottom+1);return s},J=function(){var t,r,o,c,d,f,m,v,y,g=n.elements;if((z=i.loadMode)&&I<8&&(t=g.length)){r=0,q++,null==k&&("expand"in i||(i.expand=a.clientHeight>500&&a.clientWidth>500?500:370),k=(R=i.expand)*i.expFactor),$<k&&I<1&&q>2&&z>2&&!e.hidden?($=k,q=0):$=z>1&&q>1&&I<6?R:0;for(;r<t;r++)if(g[r]&&!g[r]._lazyRace)if(P)if((v=g[r][l]("data-expand"))&&(f=1*v)||(f=$),y!==f&&(w=innerWidth+f*D,x=innerHeight+f,m=-1*f,y=f),o=g[r].getBoundingClientRect(),(L=o.bottom)>=m&&(B=o.top)<=x&&(S=o.right)>=m*D&&(F=o.left)<=w&&(L||S||F||B)&&(i.loadHidden||"hidden"!=E(g[r],"visibility"))&&(u&&I<3&&!v&&(z<3||q<4)||G(g[r],f))){if(Z(g[r]),d=!0,I>9)break}else!d&&u&&!c&&I<4&&q<4&&z>2&&(s[0]||i.preloadAfterLoad)&&(s[0]||!v&&(L||S||F||B||"auto"!=g[r][l](i.sizesAttr)))&&(c=s[0]||g[r]);else Z(g[r]);c&&!d&&Z(c)}},K=_(J),Q=function(t){h(t.target,i.loadedClass),p(t.target,i.loadingClass),C(t.target,V),b(t.target,"lazyloaded")},U=N(Q),V=function(t){U({target:t.target})},X=function(t){var e,n=t[l](i.srcsetAttr);(e=i.customMedia[t[l]("data-media")||t[l]("media")])&&t.setAttribute("media",e),n&&t.setAttribute("srcset",n)},Y=N(function(t,e,n,a,r){var s,o,c,u,z,v;(z=b(t,"lazybeforeunveil",e)).defaultPrevented||(a&&(n?h(t,i.autosizesClass):t.setAttribute("sizes",a)),o=t[l](i.srcsetAttr),s=t[l](i.srcAttr),r&&(u=(c=t.parentNode)&&m.test(c.nodeName||"")),z={target:t},(v=e.firesLoad||"src"in t&&(o||s||u))&&(C(t,j,!0),clearTimeout(f),f=d(j,2500),h(t,i.loadingClass),C(t,V,!0)),u&&y.call(c.getElementsByTagName("source"),X),o?t.setAttribute("srcset",o):s&&!u&&(O.test(t.nodeName)?function(t,e){try{t.contentWindow.location.replace(e)}catch(n){t.src=e}}(t,s):t.src=s),r&&(o||u)&&A(t,{src:s})),t._lazyRace&&delete t._lazyRace,p(t,i.lazyClass),M(function(){(!v||t.complete&&t.naturalWidth>1)&&(v?j(z):I--,Q(z))},!0)}),Z=function(t){var e,n=H.test(t.nodeName),a=n&&(t[l](i.sizesAttr)||t[l]("sizes")),r="auto"==a;(!r&&u||!n||!t[l]("src")&&!t.srcset||t.complete||g(t,i.errorClass)||!g(t,i.lazyClass))&&(e=b(t,"lazyunveilread").detail,r&&T.updateElem(t,!0,t.offsetWidth),t._lazyRace=!0,I++,Y(t,e,r,a,n))},tt=function(){if(!u){if(r.now()-v<999)return void d(tt,999);var t=W(function(){i.loadMode=3,K()});u=!0,i.loadMode=3,K(),c("scroll",function(){3==i.loadMode&&(i.loadMode=2),t()},!0)}};return{_:function(){v=r.now(),n.elements=e.getElementsByClassName(i.lazyClass),s=e.getElementsByClassName(i.lazyClass+" "+i.preloadClass),D=i.hFac,c("scroll",K,!0),c("resize",K,!0),t.MutationObserver?new MutationObserver(K).observe(a,{childList:!0,subtree:!0,attributes:!0}):(a[o]("DOMNodeInserted",K,!0),a[o]("DOMAttrModified",K,!0),setInterval(K,999)),c("hashchange",K,!0),["focus","mouseover","click","load","transitionend","animationend","webkitAnimationEnd"].forEach(function(t){e[o](t,K,!0)}),/d$|^c/.test(e.readyState)?tt():(c("load",tt),e[o]("DOMContentLoaded",K),d(tt,2e4)),n.elements.length?(J(),M._lsFlush()):K()},checkElems:K,unveil:Z}}(),T=function(){var t,n=N(function(t,e,n,i){var a,r,s;if(t._lazysizesWidth=i,t.setAttribute("sizes",i+="px"),m.test(e.nodeName||""))for(r=0,s=(a=e.getElementsByTagName("source")).length;r<s;r++)a[r].setAttribute("sizes",i);n.detail.dataAttr||A(t,n.detail)}),a=function(t,e,i){var a,r=t.parentNode;r&&(i=w(t,r,i),(a=b(t,"lazybeforesizes",{width:i,dataAttr:!!e})).defaultPrevented||(i=a.detail.width)&&i!==t._lazysizesWidth&&n(t,r,a,i))},r=W(function(){var e,n=t.length;if(n)for(e=0;e<n;e++)a(t[e])});return{_:function(){t=e.getElementsByClassName(i.autosizesClass),c("resize",r)},checkElems:r,updateElem:a}}(),B=function(){B.i||(B.i=!0,T._(),x._())};return n={cfg:i,autoSizer:T,loader:x,init:B,uP:A,aC:h,rC:p,hC:g,fire:b,gW:w,rAF:M}}}(t,t.document);t.lazySizes=n,"object"==typeof module&&module.exports&&(module.exports=n)}(window);