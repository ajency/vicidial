<noscript id="deferred-styles">
	<link rel="stylesheet" type="text/css" href="/css/combine.css">
</noscript>
<script>
  var loadDeferredStyles = function() {
    var addStylesNode = document.getElementById("deferred-styles");
    var replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement)
    addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
  else window.addEventListener('load', loadDeferredStyles);
</script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://apis.google.com/js/platform.js"></script>
<script src="https://unpkg.com/popper.js@1.14.4/dist/umd/popper.js"></script>

@yield('footjs')
<script type="text/javascript">
	window.lazySizesConfig = window.lazySizesConfig || {};
	lazySizesConfig.loadMode = 3;
</script>

<script type="text/javascript" src="/js/combine.js"></script>


<script type="text/javascript" src="/js/custom.js"></script>

<script type="text/javascript" src="/js/cart.js"></script>