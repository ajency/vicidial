@extends('layouts.email')
@section('content')
@php
  $orderDetails = $order->getOrderDetails();
  $order_info = $orderDetails['order_info'];
  $shipping_address = $orderDetails['shipping_address']; 
  $sub_orders = $orderDetails['sub_orders'];
  $order_summary = $orderDetails['order_summary'];
  $user_name = $order->cart->user->name;
@endphp

      <tr>
         <td style="text-align:center;padding-bottom:10px;">
            <a href="#" style="cursor: default;">
              <img src="{{CDN::asset('/img/order-success-banner.jpg') }}" style="margin-bottom:0px;max-width:100%;height:auto;border:0" width="650" border="0" class="CToWUd">
            </a>
         </td>
      </tr>
      <!-- header ends -->

      <!-- Order No -->
     <tr>
       <td style="font-size:16px;text-align:right">Order No: <strong>{{$order_info['txn_no']}}</strong></td>
     </tr>
     <!-- Order No ends -->
     <!-- Hello intro -->
     <tr>
       <td style="font-size:17px;text-align:left;color:#777676;padding:20px 0;line-height: 22px;">
          <strong style="display: block;margin-bottom: 5px;color: #000;">Hello {{$user_name}},</strong>
          We are thrilled to confirm your order, and promise to ship it to you very soon! <br>
          Get ready to experience happiness with our range of kids fashion that is all about trends, fashion, style and comfort!
       </td>
     </tr>
     <!-- Intro ends -->
      <!-- Order details -->
     <tr>
       <td style="border-top:4px double #efb947;border-bottom:4px double #efb947;margin:30px 0 0;width:100%;padding:20px 0 20px;color: #777676;font-size: 15px;">

      <table border="0" cellspacing="0" cellpadding="0" style="padding:20px 0;font-family:Arial,Helvetica,sans-serif;width:100%;margin:0 auto;color:#777676;">
            <tbody>
               <tr>
                  <td width="60%">
                   <div style="float: left;width: 100%;">
                      <div style="font-weight: bold;text-transform: uppercase;color: #000000;letter-spacing: 1px;">ORDER DETAILS:</div>
                      <div style="margin-top: 20px;">Order No: <a href="{{url('/#/account/my-orders/')}}/{{$order_info['txn_no']}}" style="color:#004283;"><strong style="color: #000000;">{{$order_info['txn_no']}}</strong></a></div>
                      <div style="margin-top: 10px;">Date: {{$order_info['order_date']}}</div>
                      <div style="margin-top: 10px;">Amount: ₹{{$order_info['total_amount']}}</div>
                      <div style="margin-top: 30px;">
                         <a href="{{url('/#/account/my-orders/')}}" style="text-transform: uppercase;padding: 10px;text-decoration: none;background-color: #f9bc23;color: #000;font-size: 13px;">MANAGE ORDERS</a>
                      </div>
                   </div>
                </td>
                <td width="40%">
                 <div style="float: left;width: 100%;">
                    <div style="font-weight: bold;text-transform: uppercase;color: #000000;letter-spacing: 1px;">YOUR ORDER WILL BE SENT TO:</div>
                    <div style="margin-top: 20px;line-height: 20px;">{{$shipping_address['name']}} <br>
                    {{$shipping_address['address']}}<br>
                    {{$shipping_address['locality']}}<br>
                    {{$shipping_address['city']}} {{$shipping_address['pincode']}} <br>
                    {{$shipping_address['state']}} <br>
                    Mobile: +91 {{$shipping_address['phone']}}
                    @if($shipping_address['landmark']!="")
                    <br><span style="display: block;font-size: 14px;margin-top: 5px;">Landmark: {{$shipping_address['landmark']}}</span>
                    @endif
                    </div>
                 </div>
                </td>
              </tr>
            </tbody>
          </table>
      </td>
     </tr>
     <!-- order details ends -->
      <!-- What you ordered -->
      <tr>
         <td style="padding-top: 20px;padding-bottom:10px;vertical-align:top">
            <div style="font-weight: bold;text-transform: uppercase;color: #000000;letter-spacing: 1px;font-size: 15px;">HERE IS WHAT YOU ORDERED:</div>
         </td>
      </tr>
      
      <tr>
        <td>
            <table class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931items" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin-top:20px;margin-bottom: 20px;">

          @foreach ($sub_orders as $sub_order)

            @foreach( $sub_order['items'] as $item)
              @php
                $image_1x = CDN::asset('/img/img-placeholder.png');
                if(count((array)$item['images'])>0){
                  $image_1x = $item['images']['1x'];
                }
              @endphp

               <tbody>
                   <tr>
                       <td width="12%" valign="middle" style="text-align: center;">
                           <img title="Image" src="{{$image_1x}}" alt="Image" class="CToWUd">
                        </td>
                        <td width="68%" class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931cell-content m_-1366001226154905177m_-6808368826616678290m_8600340093737608931product-info" style="text-align:left;padding-left: 10px;">
                           <a href="{{url('/')}}/{{$item['product_slug']}}/buy?size={{$item['size']}}" style="color: #000;">
                              <p class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931product-name" style="text-transform: capitalize;font-weight: bold;margin-top: 0;margin-bottom: 5px;font-size: 16px;">{{$item['title']}}</p>
                           </a>
                           <p class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931ship-txt" style="margin-top: 6px;color: #777676;font-size: 15px;margin-bottom: 8px;">
                              Size: {{$item['size']}} | Qty: {{$item['quantity']}}
                           </p>
                           @if(! empty($sub_order['store_address']))
                           <p style="margin-top: 10px;color: #777676;font-size: 14px;line-height: 18px;">Sold by: {{$sub_order['store_address']['store_name']}} - {{$sub_order['store_address']['locality']}}, {{$sub_order['store_address']['city']}}</p>
                            @endif
                        </td>
                        <td class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931cell-content m_-1366001226154905177m_-6808368826616678290m_8600340093737608931align-right" style="text-align:right">
                           <strong class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931price" style="padding-right:8px;font-size: 15px;">₹{{$item['price_final']}}</strong>
                           @if($item['price_final'] != $item['price_mrp'])
                           <div style="margin-top: 8px;">
                              <small style="text-decoration: line-through;padding-left: 5px;padding-right: 5px;margin-right: 5px;color: #6c757d;font-size: 12px;border-right: 1px solid;">₹{{$item['price_mrp']}}</small>
                              <span class="kss-discount text-danger" style="color: #28a745;font-size: 12px;">{{ calculateDiscount( $item['price_mrp'],$item['price_final']) }}% OFF</span>
                           </div>
                           @endif
                        </td>
                     </tr>
               </tbody>
               @if(!$loop->last)
               <tbody>
                  <tr>
                     <td><p></p></td>
                  </tr>
               </tbody>  
               @endif  

               @endforeach

               @endforeach                     
            </table>
            <hr style="border:none;border-top:4px double #efb947;">
        </td>
    </tr>
    <tr>
      <td style="float:right;width:100%">
         <table class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931table-totals" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 10px;">
            <tbody>
               <tr>
                  <table class="m_-1366001226154905177m_-6808368826616678290m_8600340093737608931table-totals" cellpadding="0" cellspacing="0" border="0" width="100%" style="">
                      <tbody>
                         <tr>
                            <td width="30%"></td>
                            <td width="50%">
                               <div style="color: #777676;margin-bottom: 10px;text-align: right;font-size: 15px;">Total Item Price :</div>
                               <div style="color: #777676;margin-bottom: 10px;text-align: right;font-size: 15px;">Sub-total :</div>
                               @if($order_summary['cart_discount'] > 0)
                               <div style="color: #777676;margin-bottom:10px;text-align: right;font-size: 15px;">Promotion Discount :</div>
                               @endif
                               <div style="color: #777676;margin-bottom: 10px;text-align: right;font-size: 15px;">Shipping :</div>
                               <div style="margin-top: 20px;text-align: right;font-size: 15px;"><strong>ORDER TOTAL :</strong></div>
                            </td>
                            <td width="10%">
                               <div style="width: 75px;text-align:right;margin-bottom:10px;font-size: 15px;"><strong style="color: #000000;">₹{{$order_summary['mrp_total']}}</strong></div>
                               <div style="text-align: right;width: 75px;margin-bottom:10px;font-size: 15px;"><strong style="color: #000000;">₹{{$order_summary['sale_price_total']}}</strong></div>
                               @if($order_summary['cart_discount'] > 0)
                               <div style="text-align: right;width: 75px;margin-bottom: 10px;font-size: 15px;"><strong style="color: #28a745;">- ₹{{$order_summary['cart_discount']}}</strong></div>
                               @endif
                               <div style="text-align: right;width: 75px;font-size: 15px;"><strong style="color: #000000;">₹{{$order_summary['shipping_fee']}}</strong></div>
                               <div style="text-align: right;width: 75px;margin-top: 20px;color: #000;font-size: 15px;"><strong>₹{{$order_summary['you_pay']}}</strong></div>
                            </td>
                         </tr>
                      </tbody>
                   </table>
               </tr>
            </tbody>
         </table>
        </td>
    </tr>
    <tr>
      <td><p style="font-size:13px;margin:0 0 10px 0"></p></td>
    </tr>


@endsection