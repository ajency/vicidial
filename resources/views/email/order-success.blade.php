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


<!-- Your order hero block -->


    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffe599;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffe599;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#ffe599;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">  
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 22px; line-height: 26px;"><strong>Order Placed Successfully!</strong></span></p></div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    <div align="center" class="img-container center  autowidth  " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center  autowidth " align="center" border="0" src="{{CDN::asset('/img/order-placed.png') }}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;" />
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  
                    
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>




<!-- Order summary block -->



    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                      <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px;">  
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#000000;text-align:left;">
      <p style="margin: 0;font-size: 15px;line-height: 14px;text-align: left;margin-top: 10px;"><span style="font-size: 18px;line-height: 19px;">Hi <strong>{{$user_name}}</strong>, your order has been successfully placed.</span></p>
      </div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>


<div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-top: 15px;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;/* padding-top: 17px; */">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="312" style=" width:312px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px;">  
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 17px;line-height: 18px;display: block;margin-bottom: 10px;"><strong> Order Details</strong></span></p>

    <p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Order No: <strong>{{$order_info['txn_no']}}</strong></span></p><p style="margin: 0;font-size: 12px;line-height: 14px;;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Placed On:<strong>&nbsp;{{$order_info['order_date']}}</strong></span></p><p style="margin: 0;font-size: 12px;line-height: 14px;;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Total amount: <strong>₹{{$order_info['total_amount']}}</strong></span></p>
    </div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              <!--[if (mso)|(IE)]></td><td align="center" width="312" style=" width:312px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 20px; padding-left: 20px; padding-top: 10px; padding-bottom: 10px;">  
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 17px;line-height: 18px;display: block;margin-bottom: 10px;"><strong>Delivery Address</strong></span></p>

<p style="margin: 0;font-size: 12px;line-height: 22px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">{{$shipping_address['name']}}, {{$shipping_address['address']}}, {{$shipping_address['locality']}}, @if($shipping_address['landmark']!=""){{$shipping_address['landmark']}},@endif {{$shipping_address['city']}}, {{$shipping_address['state']}} {{$shipping_address['pincode']}}</span></p><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Mobile: <strong> +91 {{$shipping_address['phone']}}</strong></span></p></div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>




<!-- Your shopping Bag block -->


    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:10px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:10px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 5px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #d3dbe3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span>&#160;</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 5px; padding-left: 5px; padding-top: 5px; padding-bottom: 5px;"><![endif]-->
  <div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 5px; padding-left: 5px; padding-top: 5px; padding-bottom: 5px;">  
    <div style="line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:12px;color:#555555;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px;margin-top: 10px;"><span style="font-size: 20px; line-height: 26px;">Order Items</span></p></div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>



<!-- Shipment 1  -->
@foreach ($sub_orders as $sub_order)
<div>
<div style="background-color: transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;" class="block-grid two-up ">

    <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!-->
              <div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;float: left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shipment {{$loop->iteration}}</span></p></div>
    
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align: right;float: right;"><p style="margin: 0;font-size: 12px;line-height: 14px;"><span style="font-size: 15px; line-height: 18px;">Qty: {{$sub_order['number_of_items']}} {{$sub_order['number_of_items'] == 1 ? "Item" : "Items"}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p></div>
    
    <b style="clear: both;display: table;"></b>
    
    
        </div>
      </div>
    </div>
    </div>
  </div>
  </div>

@if(! empty($sub_order['store_address']))
<div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
                      <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color: #7d7d7d;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;padding-right: 20px;padding-left: 20px;padding-top: 10px;padding-bottom: 10px;font-size: 13px;border-top: 1px solid #d6d6d6;line-height: 18px;"><strong>Sold by:</strong> {{$sub_order['store_address']['store_name']}} - {{$sub_order['store_address']['locality']}}, {{$sub_order['store_address']['city']}} </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>

  @endif


<!-- Shipment separator -->

   <div style="">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-bottom: 15px;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
              <hr style="border-color: rgba(255, 255, 255, 0.49019607843137253);margin-bottom: -1px;">  
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>


<!-- Shipment separator ends-->


<!-- Order 1 -->
@foreach( $sub_order['items'] as $item)
@php
  $image_1x = CDN::asset('/img/img-placeholder.png');
  if(count((array)$item['images'])>0){
    $image_1x = $item['images']['1x'];
  }
@endphp

   <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid mixed-two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

            <div class="col num8" style="width:100% !important">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 20px; padding-left: 20px; padding-bottom: 10px;"> 
    <a href="{{url('/')}}/{{$item['product_slug']}}/buy?size={{$item['size']}}">
  <img class="center fixedwidth" align="center" border="0" src="{{$image_1x}}" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: 0;height: auto;float: left;width: 100%; margin-left: auto;margin-right: 20px;max-width: 60px;@php if(count((array)$item['images'])==0) { @endphp background-color: #f9f9f9;max-width: 55px; @php } @endphp" width="41.6666666666667" />
  </a>
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;float:left;width:68%;"><p style="margin: 0;font-size: 12px;line-height: 14px"><a href="{{url('/')}}/{{$item['product_slug']}}/buy?size={{$item['size']}}" style="color: #b18005;"><span style="font-size: 17px; line-height: 20px;text-transform: capitalize;">{{$item['title']}}</span></a></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;padding-top:3px;padding-bottom:3px;display: inline-block;">Size:&#160;{{$item['size']}}</span><span style="padding-left: 5px;padding-right: 5px;display: inline-block;position: relative;top: -2px;left: -2px;">|</span><span style="font-size: 15px; line-height: 18px;">Qty:&#160;{{$item['quantity']}}</span></p><p style="margin: 0;font-size: 12px;line-height: 14px;padding-top: 3px;"><span style="font-size: 15px; line-height: 18px;">Item Price: <strong>₹{{$item['price_final']}}</strong>@if($item['price_final'] != $item['price_mrp'])<small style="text-decoration: line-through;">   ₹{{$item['price_mrp']}}</small><small style="color: #ff353b;padding-left: 5px;">{{ calculate_discount( $item['price_mrp'],$item['price_final']) }}% OFF</small>@endif</span></p></div>  
    <b style="clear: both;display: table;"></b>
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>



<!-- Separator -->
@if(!$loop->last)

<div style="">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-bottom: 15px;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;width: 80%;margin: 0 auto;">
              <hr style="border-color: rgba(255, 255, 255, 0.49019607843137253);margin-bottom: -1px;">  
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
@endif

<!-- Separator ends -->
@endforeach

<!-- Order 2 -->

</div>
@endforeach
<!-- Shipment 1 ends -->


<!-- Shipment 2 starts -->




<!-- Shipment 2 ends -->


    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="625" style=" width:625px; padding-right: 0px; padding-left: 0px; padding-top:10px; padding-bottom:10px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num12" style="min-width: 320px;max-width: 625px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:10px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="divider " style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
    <tbody>
        <tr style="vertical-align: top">
            <td class="divider_inner" style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                <table class="divider_content" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #d3dbe3;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>



 
<div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid mixed-two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">

              <!--[if (mso)|(IE)]></td><td align="center" width="417" style=" width:417px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 416px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">  
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;padding-right: 10px;padding-left: 10px;">
    <p style="margin: 0;font-size: 18px;line-height: 25px;font-weight: 600;">Billing details</p>
    <p style="margin: 0;font-size: 12px;line-height: 14px;margin-top: 5px;margin-bottom: 5px;padding-top: 10px;/* padding-bottom: 3px; */border-top: 1px solid #ddd;"><span style="font-size: 17px; line-height: 28px;">Total Item Price:&nbsp; &nbsp;₹{{$order_summary['mrp_total']}}</span><br><span style="font-size: 17px; line-height: 28px;">Sub Total:&nbsp; ₹{{$order_summary['sale_price_total']}}</span><br>@if($order_summary['cart_discount'] > 0)<span style="font-size: 17px; line-height: 28px;">Promotion Discount:&nbsp; <span style="color: #28a745;">- ₹{{$order_summary['cart_discount']}}</span></span><br>@endif<span style="font-size: 17px; line-height: 28px;">Shipping:&nbsp; ₹{{$order_summary['shipping_fee']}}</span><br></p><p style="margin-top: 4px;font-weight: 600;padding-top: 10px;margin-bottom: 0;border-top: 1px solid #ddd;"><span style="font-size: 18px;line-height: 26px;">Total:&nbsp; &nbsp;₹{{$order_summary['you_pay']}}</span></p></div> 
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>








@endsection