<div><b>A return item query has been submitted. Below are the details</b></div>
<br>
<div><b>Name</b> : {{$data["name"]}}</div>
<br>
<div><b>Mobile No</b> : {{$data["mobile"]}}</div>
<br>
<div><b>Order No</b> : {{$data["txnno"]}}</div>
<br>
<div><b>Item</b> : <a href="{{{{url('/')}}/{{$data['product_slug']}}/buy?size={{$data['size']}}}}">{{$data["item"]}}</a></div>
<br>
<div><b>Quantity</b> : {{$data["quantity"]}}</div>
<br>
<div><b>Reason</b> : {{$data["reason"]}}</div>
<br>
<div><b>Comments</b> : {{$data["comments"]}}</div>