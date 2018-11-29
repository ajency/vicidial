<li class="nav-item" data-target="{{$filter['template']}}">
	{{$filter["header"]["display_name"]}}
	<?php
	$sel_arr = array_column($filter["items"], 'is_selected');
	$out = array_filter($sel_arr, function($v, $k) {
	    return $v == true;
	}, ARRAY_FILTER_USE_BOTH);
	?>
	@if (count($out)>0)<small class="filter-count">{{count($out)}}</small> @endif
</li>