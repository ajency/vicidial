@extends('layouts.email')
@section('content')
@php 
	$orderDetails = $order->getOrderDetails();
	print_r($orderDetails);
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
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 22px; line-height: 26px;"><strong>Your order is on its way!</strong></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  
                    <div align="center" class="img-container center  autowidth  " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center  autowidth " align="center" border="0" src="/img/truck.gif" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 136px" width="136" />
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  
                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
	<div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#000000;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 16px; line-height: 19px;">Hi <strong>Josh</strong>, we've received order No: <strong>A12094653</strong> and are working on it now.</span></p><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center"><span style="font-size: 16px; line-height: 19px;">We'll email you an update when we've shipped it.</span></p></div>	
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
	<div style="color:#555555;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="line-height:14px;font-size:12px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;text-align: center;"><span style="font-size: 20px; line-height: 26px;">Order Summary</span></p></div>	
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
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="312" style=" width:312px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
	<div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Order No: <strong> A12094653</strong></span></p><p style="margin: 0;font-size: 12px;line-height: 14px;;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Placed On:<strong>&#160;23rd April 2018</strong></span></p><p style="margin: 0;font-size: 12px;line-height: 14px;;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Total amount: <strong>₹195 for 1 item</strong></span></p></div>	
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
	<div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;"><span style="font-size: 15px; line-height: 18px;">Shipping Address:</span></p><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><strong><span style="font-size: 15px; line-height: 18px;">Josh Makwey 96 Wiilmedrie St San jose, CA 95987</span></strong></p><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;"><span style="font-size: 15px; line-height: 18px;">Mobile: <strong> +91 8377599630</strong></span></p></div>	
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
		<div style="line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:12px;color:#555555;text-align:left;"><p style="margin: 0;line-height: 14px;text-align: center;font-size: 12px;margin-top: 10px;"><span style="font-size: 20px; line-height: 26px;">Your Shopping Bag</span></p></div>	
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

<div style="background-color: transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;/* margin-bottom: 10px; */" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          

              
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;/* padding-left: 10px; */">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-right: 0px;padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 0px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;font-weight: 600;"><span style="font-size: 15px; line-height: 18px;">Shipment 1</span></p></div>  
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;/* padding-right: 5px; */">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-right: 0px;padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;padding-right: 10px;padding-left: 10px;padding-top: 10px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align: right;"><p style="margin: 0;font-size: 12px;line-height: 14px;font-weight: 600;"><span style="font-size: 15px; line-height: 18px;">2 item</span></p></div> 
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

    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid mixed-two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="208" style=" width:208px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num4" style="display: table-cell;vertical-align: top;max-width: 320px;min-width: 208px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center fixedwidth" align="center" border="0" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/8c0598b1-aca3-4fb5-b862-82c999e7ba74/test1-clientside/image1.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 41.6666666666667px; margin-left: auto;
    padding-right: 20px;" width="41.6666666666667" />
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              <!--[if (mso)|(IE)]></td><td align="center" width="417" style=" width:417px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 416px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
	<div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><a href="#" style="text-decoration: none;color: #004283;font-weight: 600;"><span style="font-size: 17px; line-height: 20px;text-transform: capitalize;">Cotton Rich Super&#160;Skinny&#160;Fit Jeans</span></a></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Size:&#160;1-2Y</span><br /><span style="font-size: 15px; line-height: 18px;">Qty:&#160;2</span></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Item Price: <strong>₹300</strong></span></p></div>	
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

<div style="">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-bottom: 15px;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;width: 80%;margin: 0 auto;">
              <hr style="border-color: rgba(255, 255, 255, 0.49019607843137253);margin-bottom: -1px;">  
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>

<!-- Separator ends -->


<!-- Order 2 -->

    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid mixed-two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="208" style=" width:208px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num4" style="display: table-cell;vertical-align: top;max-width: 320px;min-width: 208px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center fixedwidth" align="center" border="0" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/8c0598b1-aca3-4fb5-b862-82c999e7ba74/test1-clientside/image1.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 41.6666666666667px; margin-left: auto;
    padding-right: 20px;" width="41.6666666666667" />
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              <!--[if (mso)|(IE)]></td><td align="center" width="417" style=" width:417px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 416px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-bottom: 10px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><a href="#" style="text-decoration: none;color: #004283;font-weight: 600;"><span style="font-size: 17px; line-height: 20px;text-transform: capitalize;">Cotton Rich Super&#160;Skinny&#160;Fit Jeans</span></a></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Size:&#160;1-2Y</span><br /><span style="font-size: 15px; line-height: 18px;">Qty:&#160;2</span></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Item Price: <strong>₹300</strong></span></p></div> 
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


<!-- Shipment 1 ends -->


<!-- Shipment 2 starts -->

<div style="background-color: transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;/* margin-bottom: 10px; */" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          

              
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;/* padding-left: 10px; */">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-right: 0px;padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 0px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px;margin-bottom: 5px;font-weight: 600;"><span style="font-size: 15px; line-height: 18px;">Shipment 2</span></p></div>  
  </div>
  <!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              
            <div class="col num6" style="max-width: 320px;min-width: 312px;display: table-cell;vertical-align: top;/* padding-right: 5px; */">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-right: 0px;padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;padding-right: 10px;padding-left: 10px;padding-top: 10px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align: right;"><p style="margin: 0;font-size: 12px;line-height: 14px;font-weight: 600;"><span style="font-size: 15px; line-height: 18px;">1 item</span></p></div> 
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



    <div style="">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-bottom: 15px;" class="block-grid two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
              <hr style="border-color: rgba(255, 255, 255, 0.49019607843137253);margin-bottom: -1px;">  
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>



    <div style="background-color:transparent;">
      <div style="Margin: 0 auto;min-width: 320px;max-width: 625px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;" class="block-grid mixed-two-up ">
        <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="208" style=" width:208px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num4" style="display: table-cell;vertical-align: top;max-width: 320px;min-width: 208px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div align="center" class="img-container center fixedwidth " style="padding-right: 0px;  padding-left: 0px;">
<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px;line-height:0px;"><td style="padding-right: 0px; padding-left: 0px;" align="center"><![endif]-->
  <img class="center fixedwidth" align="center" border="0" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/8c0598b1-aca3-4fb5-b862-82c999e7ba74/test1-clientside/image1.jpg" alt="Image" title="Image" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 41.6666666666667px; margin-left: auto;
    padding-right: 20px;" width="41.6666666666667" />
<!--[if mso]></td></tr></table><![endif]-->
</div>

                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              <!--[if (mso)|(IE)]></td><td align="center" width="417" style=" width:417px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 416px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
  <div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-bottom: 10px;"> 
    <div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><a href="#" style="text-decoration: none;color: #004283;font-weight: 600;"><span style="font-size: 17px; line-height: 20px;text-transform: capitalize;">Cotton Rich Super&#160;Skinny&#160;Fit Jeans</span></a></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Size:&#160;1-2Y</span><br /><span style="font-size: 15px; line-height: 18px;">Qty:&#160;2</span></p><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 15px; line-height: 18px;">Item Price: <strong>₹300</strong></span></p></div> 
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
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="background-color:transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width: 625px;"><tr class="layout-full-width" style="background-color:#FFFFFF;"><![endif]-->

              <!--[if (mso)|(IE)]><td align="center" width="208" style=" width:208px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num4" style="display: table-cell;vertical-align: top;max-width: 320px;min-width: 208px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    &#160;
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
              <!--[if (mso)|(IE)]></td><td align="center" width="417" style=" width:417px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><![endif]-->
            <div class="col num8" style="display: table-cell;vertical-align: top;min-width: 320px;max-width: 416px;">
              <div style="background-color: transparent; width: 100% !important;">
              <!--[if (!mso)&(!IE)]><!--><div style="border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><!--<![endif]-->

                  
                    <div class="">
	<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;"><![endif]-->
	<div style="color:#555555;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">	
		<div style="font-size:12px;line-height:14px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;color:#555555;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 17px; line-height: 28px;">Subtotal:&#160; &#160;₹300</span><br /><span style="font-size: 17px; line-height: 28px;">Shipping:&#160; ₹30</span><br /><br /><strong><span style="font-size: 22px; line-height: 26px;">Total:&#160; &#160;₹330</span></strong></p></div>	
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