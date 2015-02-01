<?php
	$chart_width = Input::get('chart_width') ? Intval(Input::get('chart_width')):1000;
	$chart_height = Input::get('chart_height') ? Intval(Input::get('chart_height')):500;
	$chart_type = Input::get('chart_type') ? Input::get('chart_type'):'AreaChart';
	$real_chart_width=intval($chart_width-200);
?>

<div class="chart_wrapper" style="width:{{$chart_width}}px;min-height:{{$chart_height}}px;margin:5px 0 5px 0;">
		<div class="chart_left">
		@if(!empty($summary))
            <b> Số liệu tổng hợp</b>
            <ul>
            @foreach($summary as $key=>$value)
                <li><span class="text-info">{{$key}}</span>: <span class="text-success">{{$value}}</span></li>
            @endforeach
            </ul>
		@endif
		</div>
		<div class="chart_right">
            {{Lava::$chart_type('Times')->outputInto('time_div')}}
            {{Lava::div($real_chart_width,$chart_height)}}
            @if(Lava::hasErrors())
                {{Lava::getErrors()}}
            @endif
		</div>
	<div class="clearfix"></div>
</div>