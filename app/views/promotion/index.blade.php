@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

@if($errors->has())
<div>
<p>Following errors occured:</p>
<ul>
	@foreach($errors->all() as $error)
		<li>{{$error }}</li>
	@endforeach
</ul>
</div>
@endif

	
<div id="promotion-container">
	<div data-bind="foreach: roomArray">			
		<label data-bind="text: id"></label>
						
		<div data-bind="foreach: $parent.promotionArray">	
		<!-- ko if: $parent.room_type_id() == room_id() -->
    	
			<ul>
				<li>Duration: <label data-bind="text: from"></label> to <label data-bind="text: to"></label></li>
				<li>Services:<label data-bind="text: services"></label></li>				
				<li>Price:<label data-bind="text: price"></label></li>
				<li>Discount rate:<label data-bind="text: discount"></label></li>
				<li>No. of days:<label data-bind="text: stays"></label></li>
				<li>
					<input type="hidden" data-bind="text: room_id" />
					<input type="hidden" data-bind="" />
					<input type="hidden" data-bind="text: to" />
					<button data-bind="click: deleteSavedPromotion">Delete</button>					
				</li>
				<li>
					<form>				
					<button data-bind="click: $root.loadSavedPromotion">Edit</button>
					</form>					
				</li>
			</ul>
    		
    	<!-- /ko -->    	
    				
		</div>
		<!-- <button data-bind="click: $parent.loadSavedPromoTimeline">Edit timeline</button> -->
		<button data-bind="click: $parent.deleteSavedPromotionTimeline">Delete timeline</button>
	</div>				
</div>


 <script type="text/javascript" src="{{url()}}/js/promotion.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	rooms = {{$rooms}};
 	calendar = {{$calendar}};

 	window.onload = function(){
 		loadPromotions();
 	} 	

	var promotions = new PromotionArray();	
	
	ko.applyBindings(promotions);
 </script>
@stop


<!-- @for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
	<th>{{ date("F",strtotime($start_date))  }}</th>
	<?php
		//$start_date = date("F",strtotime($start_date. '+1 month'));
	?>
@endfor -->	
