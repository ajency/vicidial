@extends('layouts.default')

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-4 bold mb-1 banner-title">Terms and Conditions</h1>
   </div>
</div>
<div class="container mt-3">
   <!-- Breadcrumbs -->
   <div class="row">
      <div class="col-12">
         <div class="mb-4">
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   
   <div class="row justify-content-center bg-lightgray p-sm-5">
      <div class="col-sm-12 mb-sm-3 mt-3">
         <p class="group-title group-title--black group-title--lighter mb-5">
            We value the trust you place in <a href="http://www.kidsuperstore.in">kidsuperstore.in</a>. This use of the <a href="http://www.kidsuperstore.in">www.kidsuperstore.in</a> website and the materials on this website are subject to the terms and conditions of this Legal Webpage. That’s why we insist you read these Terms of Use and Policies about Privacy, Fees, Payments, Promotions, Delivery, Returns and Refund which together form the entire Terms of Use.
         </p>
         <p class="group-title group-title--black">
            Please read these terms and conditions carefully before using the <a href="http://www.kidsuperstore.in">Kidsuperstore.in</a> website. By using this website, you acknowledge that you have read, understood, and agreed to be bound by the terms and conditions of use contained on this legal webpage. These terms and conditions of use may be amended or changed by us at any time at our discretion. You agree that your continued use of this website after any such amendment or change shall constitute your agreement to any such changes.
         </p>

         <div class="points about mt-5">
            <h4 class="group-title">
               A. What is this document about?
            </h4>
            <ol>
               <li class="group-body">
                  These Terms and conditions are made available to the User pursuant to and in accordance with the provisions of Rule 3 (1) of the Information Technology (Intermediaries Guidelines) Rules, 2011 that require publishing the rules, regulations, privacy policy and Terms for access or usage of the Website.
               </li>
               <li class="group-body">
                  These terms of use, read together with the Privacy Policy constitutes a legal and binding agreement between you and Omni Edge Retail Private Limited, a Company incorporated under the laws of India, having its registered office at:<br>
                  Shop No. 912 and 914, 9th Floor, Corporate Annexe,<br>
                  Sonawala Rd,<br>
                  Goregaon (E), Mumbai 400063<br>
                  Maharashtra, India.(“<a title="kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">kidsuperstore.in</a>”)
               </li>
               <li class="group-body">
                  The Agreement, inter alia, provides the terms that govern your access to use
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s website www.kidsuperstore.in, and
                     </li>
                     <li class="group-body">
                        its mobile and tablet applications (“Platforms”),
                     </li>
                     <li class="group-body">
                        <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s online fashion and accessories solutions, which inter alia facilitates sale and purchase of fashion merchandise (“Products”) through the Platforms, and
                     </li>
                     <li class="group-body">
                        the purchase of Products, and any other service that may be provided by Kidsuperstore.in from time to time (collectively referred to as the “Services”).
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  You hereby understand and agree that the Agreement forms a binding contract between Kidsuperstore.in and anyone who accesses, browses, or purchases the Products and uses the Services in any manner (“User”) and accordingly, you hereby agree to be bound by the terms contained in the Agreement. If you do not agree to the terms contained in the Agreement, you are advised not to proceed with purchasing the Products or using the Services. The terms contained in the Agreement shall be accepted without modification. The use of the Services would constitute acceptance of the terms of the Agreement.
               </li>
               <li class="group-body">
                   The headings and subheadings herein are included for convenience and identification only and are not intended to describe, interpret, define or limit the scope, extent or intent of the Terms or the right to use the Website by you contained herein or any other section or pages of the Website or any linked sites in any manner whatsoever.
               </li>
               <li class="group-body">
                  The Terms herein shall apply equally to both the singular and plural form of the terms defined. Whenever the context may require, any pronoun shall include the corresponding masculine and feminine. The words "include", "includes" and "including" shall be deemed to be followed by the phrase "without limitation". Unless the context otherwise requires, the terms "herein", "hereof", "hereto", "hereunder" and words of similar import refer to the Terms as a whole.
               </li>
               <li class="group-body">
                  This document is an electronic record in terms of Information Technology Act, 2000 and rules there under as applicable and the amended provisions pertaining to electronic records in various statutes as amended by the Information Technology Act, 2000. This electronic record is generated by a computer system and does not require any physical or digital signatures and forms a valid and binding agreement between the Website and the User.
               </li>
            </ol>
         </div>

         <div class="points membership mt-5">
            <h4 class="group-title">
               B. Membership Eligibility:
            </h4>
            <ol>
               <li class="group-body">
                  Use of the Website is available only to such persons who can legally contract under Indian Contract Act, 1872. Persons who are "incompetent to contract" within the meaning of the Indian Contract Act, 1872 including minors, un-discharged insolvents etc. shall not be eligible to use the Website.
               </li>
               <li class="group-body">
                  Use of the Website is available only to such persons who can legally contract under Indian Contract Act, 1872. Persons who are "incompetent to contract" within the meaning of the Indian Contract Act, 1872 including minors, un-discharged insolvents etc. shall not be eligible to use the Website.
               </li>
               <li class="group-body">
                  The Website reserves the right to terminate any membership and/or refuse to provide access to the Website if it is brought to the Website’s notice or if it is discovered that the person accessing/using the Website is under the age of 18 years.
               </li>
               <li class="group-body">
                   By accepting the Terms or using or transacting on the Website, the User irrevocably declares and undertakes that he/she is of legal age i.e. 18 years or older and capable of entering into a binding contract and such usage shall be deemed to form a contract between the Website and such Users to the extent permissible under applicable laws.
               </li>               
               <li class="group-body">
                  This Agreement is governed by the provisions of Indian law, including, but not limited to:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        the Indian Contract Act, 1872;
                     </li>
                     <li class="group-body">
                        the Information Technology Act, 2000;
                     </li>
                     <li class="group-body">
                        the rules, regulations, guidelines and clarifications framed thereunder, including the Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Information) Rules, 2011 (“SPI Rules”) and;
                     </li>
                     <li class="group-body">
                        the Information Technology (Intermediaries Guidelines) Rules, 2011 (“IG Rules”)
                     </li>
                  </ol>
               </li>
            </ol>
         </div>

         <div class="points account mt-5">
            <h4 class="group-title">
               C. User Account, Password and Security:
            </h4>
            <ol>
               <li class="group-body">
                  Any person may access the Website and the Products either by registering to the Website or using the Website as a guest. However, a guest user may not have access to all sections of the Website including certain benefits/promotional offers, which shall be reserved only for the purpose of registered Users, and which may change from time to time at the sole discretion of the Website, without notice.
               </li>
               <li class="group-body">
                  If you wish to register yourself with the Website, you shall be required to create a user account by registering through Facebook or your Email account or by filling in the details prescribed in the Website registration form. You will then receive a password and account designation upon completing the Website's registration process. You are responsible for maintaining the confidentiality of the password and account, and are fully responsible for any and all activities that occur under your password or account.
               </li>
               <li class="group-body">
                  Any communication from Kidsuperstore.in shall be sent only to your registered mobile number and/or email address or such other contact number or email address that you may designate, for any particular transaction. You shall be solely responsible to update your registered mobile number and/or email address on the Platforms in the event there is a change.
               </li>              
               <li class="group-body">
                  You agree to
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        immediately notify the Website of any unauthorized use of your password or account or any other breach of security, and
                     </li>
                     <li class="group-body">
                        ensure that you exit from your account at the end of each session.
                     </li>
                  </ol>
                  <a href="http://www.kidsuperstore.in">www.kidsuperstore.in</a> cannot and will not be liable for any loss or damage arising from your failure to comply with this Section or for any losses occurring thereto. You, as the User, waive any claims against the Website for any loss and damage suffered by you on account of your failure to comply with the Terms and reasonably expected good practices in this regard.
               </li>
               <li class="group-body">
                   If any User learns or is made or becomes aware of any instance of hacking or misuse of its User account, it shall without delay notify the Website of the same. Additionally, registered Users may be held liable for losses incurred by the Website for any loss or damage caused as a result of failure in maintaining security by the relevant User.
               </li>  
               <li class="group-body">
                   If any User provides any information that is untrue, false, not updated, and incomplete or the Website has reasonable grounds to believe that such information is untrue, false, not updated, incomplete, the Website shall have the right to suspend or terminate the relevant User account and refuse any and all current or future use of the Website (or any portion thereof).
               </li> 
               <li class="group-body">
                   The Website may be inaccessible for such purposes as it may, at its sole discretions deem necessary, including but not limited to regular maintenance. However, under no circumstances will <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> be held liable for any losses or claims arising out of such inaccessibility to the Users and the Users expressly waive any claims against <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> in this regard.
               </li> 
               <li class="group-body">
                   Users of the Website may be required to provide certain personal information and expressly permit the Website from accessing and/or collecting and retaining such personal information of the Users. Such provision and/or collection, storage, retention, use and disclosure of the personal information of the Users shall be subject to the Website’s privacy policy available at www.kidsuperstore.in/privacy
               </li> 
               <li class="group-body">
                   Third Party - At times Kidsuperstore.in may tie-up with third parties, brand owners or other partners and make available certain offers, events or special schemes. In such instances, your personal information may be shared with such third parties and/or may become available to them or be disclosed to them, such third parties may have their own applicable privacy rules and We shall not be liable for the use or misuse of Your information by such third parties.
               </li>                                                                           
            </ol>
         </div>         

         <div class="points services mt-5">
            <h4 class="group-title">
               D. Modification to the Service and Prices:
            </h4>
            <ol>           
               <li class="group-body">
                  <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> may, at any time and without having to service any prior notice to you:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        upgrade, update, change, modify, or improve the Services or a part of the Services in a manner it may deem fit;
                     </li>
                     <li class="group-body">
                        change the contents of the Agreement in substance, or as to procedure or otherwise; in each case which will be applicable to all Users; and
                     </li>
                     <li class="group-body">
                        change the prices of the products.
                     </li>
                  </ol>
                  Such changes will be effective when posted on the Website. Notwithstanding the foregoing, by continuing to use the Website after we remove and/ or post any such changes, you accept the Terms as modified. We also, reserve the right to modify or discontinue the Service (or any part or content thereof) without notice at any time and shall not be liable to you or to any third-party for any modification, price change, suspension or discontinuance of the Service. These Terms will continue to apply until terminated by either you or www.kidsuperstore.in in accordance with the terms set out below:
                  <br><br>
                  a. The agreement with <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> can be terminated by
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        not accessing the Website; or
                     </li>
                     <li class="group-body">
                        closing Your Account, if such option has been made available to You.
                     </li>
                  </ol>
                  b. The above clause shall also apply to any additional Terms applicable to the use of the Website and <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> reserves the right to terminate access to the Website (including any services offered as part thereof).
                  <br><br>
                  Notwithstanding the foregoing, these provisions set out in these Terms which by their very nature survive are meant to survive termination, shall survive the termination/expiry of this agreement. You hereby agree that this is in the fairness of things given the nature of the business and its operations and you will abide by them. As such, you must keep yourself updated at all times and review the terms of the Agreement from time to time.
               </li>
            </ol>
         </div>    

         <div class="points obligations mt-5">
            <h4 class="group-title">
               E. User Covenants an Obligations:
            </h4>
            <ol>
               <li class="group-body">
                  As mandated under the provisions of Regulation 3(2) of the IG Rules, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> hereby informs you that you are prohibited from hosting, displaying, uploading, modifying, publishing, transmitting, updating or sharing any information that:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        belongs to another person and to which you do not have any right;
                     </li>
                     <li class="group-body">
                        is grossly harmful, harassing, blasphemous, defamatory, obscene, pornographic, paedophilic, libellous, invasive of another's privacy, hateful, or racially, ethnically objectionable, disparaging, relating or encouraging money laundering or gambling, or otherwise unlawful in any manner whatever;
                     </li>
                     <li class="group-body">
                        is misleading in any way;
                     </li>
                     <li class="group-body">
                        harms minors in any way;
                     </li>
                     <li class="group-body">
                        violates any law for the time being in force;
                     </li>
                     <li class="group-body">
                        deceives or misleads the addressee about the origin of such messages or communicates any information which is grossly offensive or menacing in nature;
                     </li>
                     <li class="group-body">
                        impersonates or defames another person; or
                     </li>
                     <li class="group-body">
                        contains software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer resource.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  You are also prohibited from:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        violating or attempting to violate the integrity or security of the Platforms or <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>K’s Content;
                     </li>
                     <li class="group-body">
                        transmitting any information on or through the Platforms that is disruptive or competitive to the provision of Services by <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in
                     </li>
                     <li class="group-body">
                        intentionally submitting on the Platforms, false or inaccurate information;
                     </li>
                     <li class="group-body">
                       using any engine, software, tool, agent or other mechanism (such as spiders, robots, avatars, worms, time bombs, Easter eggs, cancelbots, intelligent agents, etc.) to navigate or search the Platforms;
                     </li>
                     <li class="group-body">
                        attempting to decipher, decompile, disassemble or reverse engineer any part of the Platforms; or
                     </li>
                     <li class="group-body">
                        copying or duplicating in any manner any of the <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s Content.
                     </li>
                  </ol>
               </li>   
               <li class="group-body">
                  You are also obligated to:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        refrain from acquiring any ownership rights by downloading the Kidsuperstore.in’s Content;
                     </li>
                     <li class="group-body">
                        read the Agreement and agree to accept the terms and conditions set out therein;
                     </li>
                     <li class="group-body">
                        refrain from copying or modifying the <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s Content available on the Platforms for any purpose;
                     </li>
                     <li class="group-body">
                        comply with all applicable laws in connection with your use of the Platforms;
                     </li>
                     <li class="group-body">
                        not refuse the delivery of purchased Products except when damages and deficiencies can be identified upfront at the time of delivery; and
                     </li>
                     <li class="group-body">
                        use the Products for personal, non-commercial use.
                     </li>
                  </ol>
               </li> 
              <li class="group-body">
                  A User may be considered fraudulent or loss to business due to fraudulent activity if any of the following scenarios are met:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        User doesn't reply to the payment verification mail sent by <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>;
                     </li>
                     <li class="group-body">
                        User fails to produce adequate documents during the payment details verification;
                     </li>
                     <li class="group-body">
                        Misuse of another Users's phone/email;
                     </li>
                     <li class="group-body">
                        User uses invalid address, email and phone no.;
                     </li>
                     <li class="group-body">
                        Overuse of a voucher code;
                     </li>
                     <li class="group-body">
                        Use of a special voucher not tagged to the email ID used;
                     </li>
                     <li class="group-body">
                        User returns the wrong product;
                     </li>
                     <li class="group-body">
                        User refuses to pay for an order;
                     </li>
                     <li class="group-body">
                        Users involved in the snatch and run of any order;
                     </li>
                     <li class="group-body">
                        Miscellaneous activities conducted with the sole intention to cause loss to business/revenue to <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>;
                     </li>
                     <li class="group-body">
                        User with a very high return rate; and
                     </li>
                     <li class="group-body">
                        Repeated request for monetary compensation for fake/used order.
                     </li>
                  </ol>
               </li>                                            
            </ol>
         </div>  

         <div class="points listing mt-5">
            <h4 class="group-title">
               F. Listing and Selling:
            </h4>
            <ol>
               <li class="group-body">
                  Display of Products for purchase on the Platforms is merely an invitation to offer. An order placed by a User for purchase of a Product constitutes an offer. All orders placed by Users on the Platforms are subject to the availability of such Product, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s acceptance of the User’s offer and the User’s continued adherence to the terms of the Agreement.
               </li>
               <li class="group-body">
                  All the information, text, graphics, images, logos, button icons, software code, interface, design and the collection, arrangement and assembly of the content on the Platforms or any of the other Services are the property of <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>, affiliates, suppliers, vendors as the case may be, and are protected under copyright, trademark and other applicable laws.
               </li>
               <li class="group-body">
                  You shall not modify the Content or reproduce, display, publicly perform, distribute, reverse engineer or otherwise use the Content on <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> in any way for any public or commercial purpose or for personal gain.
               </li>
               <li class="group-body">
                   You have the authority to you view and access <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s Content solely for identifying Products, carrying out purchases of Products and processing returns and refunds, in accordance with Return and Refund Policy, if any. Therefore, you have a limited, revocable permission to access and use the Services. This permission does not include permission for carrying out any resale of the Products or commercial use of the Kidsuperstore.in’s Content, any collection and use of product listings, description, or prices, and, any derivative use of the Platforms or of <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s Content.
               </li>
               <li class="group-body">
                  <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> provides visual representations on the Platforms including graphics, illustrations, photographs, images, videos, charts, screenshots, infographics and other visual aids, as a means to assist the Users in identifying the Products of their choice.
               </li>
               <li class="group-body">
                  Reasonable efforts are made to provide accurate visual representations, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> disclaims any guarantee or warranty of exactness of such visual representation or description of the Product, with the actual Product ultimately delivered to Users. The appearance of the Product when delivered may vary for various reasons.
               </li>
               <li class="group-body">
                  The User shall assume all risks, liabilities, and consequences if his/her account has been accessed illegally or without authorisation through means such as hacking and if through such unauthorised access, a purchase of Products has been made through the Services. It is specifically clarified that payments of monies towards any Products purchased through the Services by unauthorised or illegal use of the User’s account shall entirely be borne by the User.
               </li>
               <li class="group-body">
                  All rights and liabilities of <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> with respect to any Services to be provided by it shall be restricted to the scope of the Agreement. In addition to the Agreement, you shall also ensure that you are in compliance with the terms and conditions of the third parties, whose links are contained/embedded in the Services. It is hereby clarified that <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> shall not be held liable for any transaction between you and any such third parties.
               </li>
               <li class="group-body">
                  While <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> shall make reasonable endeavors to maintain high standards of security and shall provide the Services by using reasonable efforts, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> shall not be liable for any interruption that may be caused to your access or use of the Services.
               </li>
            </ol>
         </div>                      

         <div class="points products mt-5">
            <h4 class="group-title">
               G. Products:
            </h4>
            <ol>
               <li class="group-body">
                  All Products exhibited on the Website are on an “as is” and “as available” basis. Images of products are for and by reference only and actual Product may vary from the corresponding image exhibited. The Website disclaims any liabilities arising out of any discrepancies to this end.
               </li>
               <li class="group-body">
                  The Website operates as a market place and also provides an online platform to various Sellers to advertise, display, make available and sell various Products (including services ancillary to the products and services), vouchers. In such circumstances, Website merely facilitates the engagement of the Users and various Sellers and provides such other services as are incidental and ancillary thereto. Additionally, the Website reserves the right to terminate the services offered at any time to the Users without any notice.
               </li>
               <li class="group-body">
                  The quality of any Products, Services, information, or other material purchased or obtained by you from such Sellers through the Website is not endorsed or supported by the Company and is the sole liability of the respective Seller. Alterations to certain aspects of your order such as the merchandise brand, size, color etc. may be required due to limitations caused by availability of product difference in size charts of respective brands etc.
               </li>
               <li class="group-body">
                   Prices for Products are subject to change without prior notice, and at any time whatsoever, irrespective of whether an item has been earmarked/wish listed by a User. The Website disclaims any and all claims and/or liabilities arising from such revision in prices.
               </li>
            </ol>
         </div>     

         <div class="points listing mt-5">
            <h4 class="group-title">
               H.Pricing, Promotions and Coupon Codes:
            </h4>
            <h5 class="font-weight-bold fz-sm">Pricing and Payment Information:</h5>
            <ol>
               <li class="group-body">
                  Prices for Products are described on our Website and are incorporated into these Terms by reference. All prices are in Indian rupees. Prices, Products and services are offered by the respective Seller and may change in accordance with the brand guidelines or other terms and conditions applicable to each Seller. Users further undertake that by initiating a transaction, the User is entering into a legally binding and enforceable contract with the Seller to purchase the products using such payment facilities as may be permitted by applicable laws and as may be accepted by the Website.
               </li>
               <li class="group-body">
                  <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> does not levy any fee for browsing the Platforms. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> may, in future, consider levying fees on the Users for using the Platforms as a whole, or for use of certain features of the Platforms. In such an event, you agree to pay any such fees, as applicable. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> does not covenant or guarantee providing you with a notice prior to enforcing such a levy of fees. Your continued usage of the Platforms after such change in the fees will be considered to be your acceptance of such changes.
               </li>
               <li class="group-body">
                  <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> may enter into agreements with third-party payment gateway aggregators and financial institutions authorized by the Reserve Bank of India for collection, refund and remittance and to facilitate payment between Users and Sellers. The Website shall initiate the remittance of the payments made by the User and the date of completion of transaction shall be after the Products are delivered to the User and such other additional time as may be agreed between Website and the Sellers.
               </li>
               <li class="group-body">
                   In order to ensure User convenience, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> offers multiple payment options to Users. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>, without prior notice to Users, reserves the right to add or delete payment options from the ones listed below:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        Payment through net banking facilities;
                     </li>
                     <li class="group-body">
                        Payment through select credit cards;
                     </li>
                     <li class="group-body">
                         Payment through select debit cards;
                     </li>
                     <li class="group-body">
                         Payments through cash on delivery; and
                     </li>
                     <li class="group-body">
                         Payments through prepaid payment instruments and electronic wallets;
                     </li>
                     <li class="group-body">
                         Any other payment option as may be provided by <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> from time to time.
                     </li>
                  </ol>
                  The payment options referred to above shall hereinafter collectively be referred to as “Payment Options”. While reasonable endeavors are made to offer the Payment Options through varied banking channels, presently, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> accepts payments only from major, select banking avenues. The list of banking channels from which <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> presently accepts payments have been set out under the Frequently Asked Questions which may be accessed here. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> does not accept payments made through international debit/credit cards.
               </li>
               <li class="group-body">
                  It is expressly clarified that accepting a User’s payment through the Payment Options is solely at <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s discretion. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> reserves the right to reject payment from a User through the Payment Options for any reason whatsoever. In order to further validate a User’s transaction, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> may request the User to submit a copy of the User’s photo identity proof (such as the User’s PAN card), failing which, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> reserves the right to reject a User’s payment made through the Payment Options.
               </li>
               <li class="group-body">
                  Cash on Delivery: The ‘cash on delivery’ Payment Option allows Users to make a cash-only payment to <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>’s delivery executive or logistic partner at the time of delivery of the purchased Product to the User. Presently, <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> offers a maximum order value of INR 2,000 (Indian Rupees Two Thousand) under the cash on delivery Payment Option. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> reserves the right not to provide cash on delivery Payment Option for certain Products (these could be Products specified by <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> or Products with value exceeding a specified amount) or locations. Users are required to peruse and accept the terms set out under the Return and Refund Policy which sets out the terms of returns and refunds for transactions carried out using the cash on delivery Payment Option.
               </li>
               <li class="group-body">
                  While availing any of the payment method/s available on the Website, the Website will not be responsible or assume any liability, whatsoever in respect of any loss or damage arising directly or indirectly to the User due to:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        Lack of authorization for any transaction/s, or
                     </li>
                     <li class="group-body">
                        Exceeding the preset limit mutually agreed by and between the User and relevant banks of the User, or
                     </li>
                     <li class="group-body">
                         Any payment issues arising out of the transaction, or
                     </li>
                     <li class="group-body">
                        Illegitimacy of the payment methods (credit/debit card frauds etc.) being used by a User;
                     </li>
                     <li class="group-body">
                        Decline of transaction for any other reason(s)
                     </li>
                     <li class="group-body">
                        Notwithstanding anything contained herein, the Website reserves the right to conduct additional verification for security or other reasons if it is not satisfied with the creditability of the User.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  All payment and delivery related conditions are in accordance with the contractual relationship impliedly established between the Seller of the Products and the User purchasing the same and payment facility provided by the Website is merely used by the User and Seller of the Product to facilitate the completion of the purchase made by the User. Use of the payment facilities provided by the Website shall not render the Website liable or responsible for the non-delivery, non-receipt, non-payment, damage, breach of representations and warranties, non-provision of after sales or warranty services or fraud as regards the Products listed on the Website. The Website shall not be responsible for any damages, interests or claims arising from not processing a transaction.
               </li>
               <li class="group-body">
                  Every User hereby agrees to provide accurate information, such as credit/debit information for purchasing Products on the Website. Every User further warrants that he/she shall not use payment information or instrument that is not lawfully owned by the User. The Website shall not utilize or share with any third party unless required as per law, regulation or court order or in accordance with the terms of the Privacy Policy. The Website disclaims all liabilities arising out of loss of any information pertaining to the Confidentiality of the credit/debit card details or pre-paid instrument account. In addition to these Terms, the terms and conditions of the bank or other financial institution shall also be applicable to every User. The Website disclaims any liability arising out of declining of payment by such bank or financial institution.
               </li>
               <li class="group-body">
                  The Website may in its sole discretion impose limits on the number of transaction which an individual holding a financial instrument may use for payment for Products. Additionally, the Website reserves the right to refuse to process transactions exceeding such limit and transactions by Users that have incurred questionable charges and amounts.
               </li>
               <li class="group-body">
                  The Website is merely a facilitator for providing the User with payment channels through automated online electronic payments (either itself or through Service Providers), cash on delivery, collection and remittance facility for the payment of Products purchased by the User on the Website using the existing authorized banking infrastructure and credit card payment gateway networks (of either the Website or Service Providers).
               </li>               
            </ol>
         </div>         

         <div class="points delivery mt-5" id="shipping">
            <h4 class="group-title">
               I. Shipping and Delivery:
            </h4>
            <h5 class="font-weight-bold fz-sm">Pricing and Payment Information:</h5>
            <ol>
               <li class="group-body">
                  All Products purchased from the Website shall be delivered to the User by standard courier services by <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> on behalf of the respective Sellers through a logistics partner or by the Sellers themselves. All deliveries where applicable shall be made on a best efforts basis, and while the Website will endeavor to deliver the Products on the dates intimated, the Website disclaims any claims or liabilities arising from any delay in this regard. On behalf of the Seller, a nominal fee may be charged on all cash on delivery (“COD”) orders. The COD charge can be viewed at the time of placing the order and in all order related emails. This charge shall not be refunded if an item is returned or if the cancellation request is raised after the order is shipped.
               </li>
               <li class="group-body">
                  Sellers may charge reasonable shipping and handling fees to cover the costs for packaging and posting the items. Sellers may issue promotional codes for promotional purposes only and these are to be used against purchases from the issuing Seller’s products only. Promotional codes have no cash value and cannot be exchanged for money or credit.
               </li>
               <li class="group-body">
                  The logistics partner supported by <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> will make a maximum of two attempts to deliver your order. In case the User is not reachable or does not accept delivery of products in these attempts the respective Seller reserves the right to cancel the order(s) at its discretion.
               </li>
               <li class="group-body">
                  All sales on the Website are binding in nature on both the User and Seller. The Seller is responsible for shipping up to the point of delivery or otherwise completing the transaction with the User within 3-21 days, unless there is an exceptional circumstance or occurrence of a force majeure event.
               </li>
               <li class="group-body">
                  The logistics partner supported by <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> will make a maximum of two attempts to deliver your order. In case the User is not reachable or does not accept delivery of products in these attempts the respective Seller reserves the right to cancel the order(s) at its discretion.
               </li>
               <li class="group-body">
                   Sometimes, delivery may take longer due to inter alia:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        bad weather
                     </li>
                     <li class="group-body">
                        flight delays
                     </li>
                     <li class="group-body">
                         political disruptions
                     </li>
                     <li class="group-body">
                         other unforeseen circumstances
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  In the event any delay in delivery of a Product is expected, the Website may, at its sole discretion, intimate the User who may have purchased the same, regarding such delay.
               </li>
               <li class="group-body">
                  The Website shall not be held responsible and will bear no liability in case of failure or delay of delivering the Products including any damage or loss caused to the Products.
               </li>
               <li class="group-body">
                  Where there is a likelihood of delay in delivery of the Products, the User may be notified of the same from time to time. However, no refunds may be claimed by the User for any delay in delivery of the Products, which was caused due to reasons beyond the control of the Website and/or the Seller.
               </li>
               <li class="group-body">
                  However in case where a damage has been caused to the Products ordered, the Seller shall replace the products as per the Seller’s replacement policy as may be indicated on the Website along with the Product.
               </li>
               <li class="group-body">
                  No deliveries of the Products shall be made outside the territorial boundaries of India.
               </li>
               <li class="group-body">
                   In case a User purchases multiple Products in one transaction, the Seller(s) may deliver the same together. However, this may not always be possible and shall be subject to availability of stock with the relevant Sellers.
               </li>
               <li class="group-body">
                  If a User wishes to get delivery to different addresses, then the User shall be required to purchase the Products under separate transactions and provide separate delivery addresses for each transaction, as may be required. The User agrees that the delivery can be made to the person who is present at the shipping address provided by the User.
               </li>   
               <li class="group-body">
                  <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> shall not compensate for any mental agony caused due to delay in delivery. The Users can cancel the order at any moment of time even if the delivery time exceeds the expected delivery time. If it is a prepaid order, the Users will be refunded back the price of the product in the account or payment wallet, in accordance with the options chosen by you, as soon as the order is successfully cancelled.
               </li>   
               <li class="group-body">
                  In case of third party Sellers, you agree and acknowledge that <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> is only a facilitator and is not and cannot be a party to or control in any manner any transactions on the Website. Accordingly, the sale of Products on the Website shall strictly be a bipartite agreement between you and the Sellers on the Website. <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> does not hold any title, right or interest in the Products listed on the Website. We expressly disclaim all obligations and liabilities emanating from an agreement between you and the Sellers on the Website.
               </li>               
            </ol>
         </div>                  

         <div class="points refund mt-5" id="return">
            <h4 class="group-title">
               J. Return and Refund Policy:
            </h4>
            <ol>
               <li class="group-body">
                  Our focus is complete customer satisfaction. In the event, if you are displeased with the services provided, we will refund back the money, provided the reasons are genuine and proved after investigation. Please read the fine prints of each deal before buying it, it provides all the details about the services or the product you purchase. In case of dissatisfaction from our services, clients have the liberty to cancel their order and request a refund from us. Our Policy for Return is as per the timelines mentioned below:
                     <table class="table custom-table mt-3">
                        <tbody>
                           <tr><th>Products</th><th>Brands</th><th>Returns Policy</th></tr>
                           <tr>
                              <td>Clothes and Footwear</td>
                              <td></td>
                              <td>Within 15 days of delivery</td>
                           </tr>
                           <tr>
                              <td>Other products except products mentioned below</td>
                              <td></td>
                              <td>Within 15 days of delivery</td>
                           </tr>
                           <tr>
                              <td>Socks</td>
                              <td></td>
                              <td>No returns accepted</td>
                           </tr>
                           <tr>
                              <td>Accessories</td>
                              <td></td>
                              <td>No returns accepted</td>
                           </tr>
                           <tr>
                              <td>Innerwear</td>
                              <td></td>
                              <td>No returns accepted</td>
                           </tr>
                           <tr>
                              <td>Dry Bed protector sheet</td>
                              <td></td>
                              <td>No returns accepted</td>
                           </tr>
                        </tbody>
                     </table>
               </li>
               <li class="group-body">
                   In case of returns:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        Returns should be initiated within the timelines mentioned above.
                     </li>
                     <li class="group-body">
                        Returns should be initiated within the timelines mentioned above.
                     </li>
                     <li class="group-body">
                        The product should be unwashed, unused and in an undamaged condition.
                     </li>
                     <li class="group-body">
                        The item needs to be returned along with the original packaging.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                   In case of refund: The amount shall be refunded within 7 days of receipt of the products in proper conditions.
               </li>
               <li class="group-body">
                  All Products ordered from the Website and successfully delivered to the User by the respective Seller may be returned to the Seller in accordance with the terms contained in the respective Seller policy.
               </li>
               <li class="group-body">
                  However no Products will be accepted by the Seller if
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        the Products have been damaged by the User
                     </li>
                     <li class="group-body">
                        if there is a change in the quality, quantity or other characteristics of the Product
                     </li>
                     <li class="group-body">
                        if as per the Seller the product returned is not the Product that was delivered
                     </li>
                     <li class="group-body">
                        any other circumstances that the Website and/or the Seller may notify or deem appropriate from time to time.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                   If the user wants to return the product <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> does not offer pickup of the items, then user can return the package using any courier service of his/her choice. Estimated refund of Courier Charges will be:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        For Product Weighing less than or equal to 500 gm, Flat INR. 30 will be refunded
                     </li>
                     <li class="group-body">
                        For Product weighing above 500 gm, refund will be equal to the amount mentioned on the courier slip or in proportion to the product weight (up to a maximum of INR 60/kg), whichever is minimum.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  In case of return initiated and subsequently couriered by the User himself/herself, and if it is found that the claimed shipment was not delivered to <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> or the shipment was empty, the onus shall be on the User to prove through presentation/submission of Proof of Delivery (PoD) from the concerned logistic service provider to establish his/her claim of return. However, non-receipt of Product by the Seller or <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> may lead to no refund/exchange being issued to the User. The User waives any claims against <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> in this regard.
               </li>
               <li class="group-body">
                  Refunds for courier charges shall be against a valid RVP slip/written confirmation from the courier company that the RVP has been done for a particular shipment/order.
               </li>               
               <li class="group-body">
                  In case of any discrepancy in the status of reverse pick up of a Product, (where the Users claims the Product has been returned, while our system suggests otherwise) refund will be initiated only if the Users successfully furnishes the RVP slip given at the time of the pick-up.
               </li>
               <li class="group-body">
                  <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> will not be liable for the products returned by mistake. In circumstances where a product not belonging to <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> is returned by mistake, <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> is not accountable for misplacement or replacement of the product and is not responsible for its delivery back to the User.
               </li>
               <li class="group-body">
                  Size exchange can be availed only once at the special price of an item. Please take note that this is applicable only on Products that are exchangeable, as mentioned on the product page and which shall be at the sole discretion of the Seller.
               </li>
               <li class="group-body">
                  In case of Size Exchange, the differential amount, if any, shall be forfeited. This will apply irrespective of any increase or decrease in the price of the product being exchanged.
               </li>
               <li class="group-body">
                   Once returned or in case the User does not receive the delivery within the time period agreed the User will be entitled to claim refund of the entire cost of the Product after adjusting relevant courier charges and such other charges that the Website may at its own discretion deduct. In case a User does not raise a refund claim as per the Terms, the User shall be ineligible for a refund. In the event, the refund facility is not available in full or in part for certain Products, the User shall not be entitled to a refund in respect of such Products.
               </li>
               <li class="group-body">
                   All Products ordered by the User shall be eligible to be replaced in accordance with the Seller’s replacement policy as indicated herein above, if the Product delivered is damaged, soiled or is different from the Product specifications mentioned on the Website. <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> will accept return or exchange of a Product only in accordance with the returns policy of the respective Seller.
               </li>
               <li class="group-body">
                  Refund, if any, shall be made at the same issuing bank through which the Product was purchased. For cash on delivery transactions, the User has the option to receive the refund in any bank account via NEFT (for which the User shall have to share the bank details) or, the refund will be credited to the wallet linked to his/her User account on the Website.
               </li>   
               <li class="group-body">
                  For payments made through electronic means like debit card, credit card, net banking, wallet etc. refund shall be made using the same payment mode.
               </li>   
               <li class="group-body">
                  All refunds shall be made in Indian Rupees only.
               </li>     
               <li class="group-body">
                  The User acknowledges that the Website will not be liable for any damages, interests or claims etc. resulting from non-processing an order or any delay in processing an order which is beyond control of the Website.
               </li>  
               <li class="group-body">
                  All Users and Sellers shall comply with all the applicable laws (including without limitation Foreign Exchange Management Act, 1999 and the rules made there under, Customs Act, Information and Technology Act, 2000 as amended by the Information Technology (Amendment) Act 2008, Prevention of Money Laundering Act, 2002 and the rules made there under, Foreign Contribution Regulation Act, 1976 and the rules made there under, Income Tax Act, 1961 and the rules made there under and all other laws as may be applicable.
               </li>            
            </ol>
         </div> 

         <div class="points cancellation mt-5" id="cancellation">
            <h4 class="group-title">
               K. Cancellation Policy
            </h4>
            <h5 class="group-title group-title--black">
               Cancellation by the Users
            </h5>
            <ol>
               <li class="group-body">
                  For the interest and satisfaction of our customers, if for any reason they wish to cancel their order <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> allows the customers to cancel their order.
               </li>
               <li class="group-body">
                   You can cancel your order online before the product(s) inside the order has been shipped. Applicable refund against the cancelled order will be transferred to your respective bank/card.
               </li>
               <li class="group-body">
                   In case were multiple products are ordered, even a single product of the order has been shipped, you will not be able to cancel the order.
               </li>
               <h5 class="group-title group-title--black">
                  Cancellation by the Kidsuperstore.in
               </h5>
               <li class="group-body">
                  To provide a safe and secure shopping experience, we regularly monitor transactions for fraudulent activity. In the event of detecting any suspicious activity, <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> reserves the absolute right to cancel all past, pending and future orders without any liability. <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> also reserves the right to refuse or cancel orders in scenarios like inaccuracies in pricing of product on Website and stock unavailability.
               </li>
               <li class="group-body">
                  We may also require additional verifications or information before accepting any order. We may contact you if all or any portion of your order is cancelled or if additional information is required to accept your order. If your order is cancelled after your card has been charged, the said amount will be reversed to your account. Any promotional voucher used for the cancelled orders may not be refunded. Further, in case of suspicious transactions, <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> reserves the right to inform law enforcement officials and provide them with all transaction details that may be requested for investigation of any illegal activity.
               </li>
               <li class="group-body">
                   The User may be considered loss to business if any of the following scenarios are met:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        User with a very high return rate
                     </li>
                     <li class="group-body">
                        Invalid/Incomplete address cases
                     </li>
                     <li class="group-body">
                        Repeated request for monetary compensation for petty issues Account for the Users falling in fraudulent or loss to business category may be blocked. Any credits earned through loyalty or referral program will be forfeited in such case.
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> may cancel any orders that classify as 'Bulk Order' under certain criteria at any stage of the product delivery. An order can be classified as 'Bulk Order' if it meets with the below mentioned criteria, and any additional criteria as defined by www.kidsuperstore.in
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        Value of the product exceeds INR 1,500 and/or 5 units at a time;
                     </li>
                     <li class="group-body">
                        Multiple orders placed for same product at the same address, depending on the product category;
                     </li>
                     <li class="group-body">
                        Bulk quantity of the same product ordered;
                     </li>
                     <li class="group-body">
                        Invalid address given in order details;
                     </li>
                     <li class="group-body">
                        Any malpractice used to place the order or any promotional voucher used for placing the 'Bulk Order' may not be refunded
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                   If a User raises a complaint for partial item/partial order:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        The Users is supposed to claim for pilferage within 48 hours of delivery failing which the claim will not be entertained.
                     </li>
                     <li class="group-body">
                        An Email will be sent seeking/providing following information:
                     </li>
                     <li class="group-body">
                        Short description of the case (A few questions will be asked to help us understand the scenario).
                     </li>
                     <li class="group-body">
                        The snapshots of the packet and other box (if any) (Try to cover the sides which look tampered/damaged as per the Users)
                     </li>
                     <li class="group-body">
                        The refund for prepaid orders will be done after investigation
                     </li>
                     <li class="group-body">
                         The Users may not be liable for a refund if he/she falls in any of the scenarios stated below:
                     </li>
                     <li class="group-body">
                        Users fails to provide adequate information about the case
                     </li>
                     <li class="group-body">
                        Users fails to provide snapshots of the packet and box (if any)
                     </li>
                     <li class="group-body">
                        If an opened delivery was received, pilferage claims must be made the same day Users must not dispose the packaging for 3-4 days post-delivery. We might need to pick-up your packaging for investigation at our end.
                     </li>
                  </ol>
               </li>               
            </ol>
         </div>   

         <div class="points content-use mt-5">
            <h4 class="group-title">
               L. Use of content:
            </h4>
            <ol>
               <li class="group-body">
                  The User acknowledges that there may be certain orders that the Website is unable to process or pass on to the Seller and/or which the Website must cancel owing to various reasons such as non-availability of the Website service, force majeure, credit limitations or suspected fraud etc.
               </li>
               <li class="group-body">
                   The User shall use the Website and purchase any Products available on it, for personal, non-commercial use only and shall not re-sell the same to any other person or commercialize the same in any manner whatsoever.
               </li>
               <li class="group-body">
                   The User may need to install updates that the Website or any third party may introduce from time to time to access the Products /Website including downloads and required functionality, such as bug fixes, patches, enhanced functions, missing plug-ins and new versions. By using the Website, the User shall be deemed to have agreed to receive such updates.
               </li>
               <li class="group-body">
                   The User agrees that it shall solely be responsible towards the Website and to any third party for any breach of its obligations under these Terms and for any consequences, losses or damages that may be suffered by the Website owing to such breach by a User.
               </li>
            </ol>
         </div>                             

         <div class="points links mt-5">
            <h4 class="group-title">
               M. Links:
            </h4>
            <ol>
               <li class="group-body">
                  This Website may also contains links to other websites, which are not operated by the Website. These links are provided solely for your convenience, and you access them at your own risk. The Website has no control over the linked sites and accepts no responsibility for them or for any loss or damage that may arise from your use of them. Your use of the linked sites will be subject to the terms of use and service contained within each such site.
               </li>
            </ol>
         </div>   

         <div class="points sales mt-5">
            <h4 class="group-title">
               N. Jurisdictional Issues/Sale in India Only:
            </h4>
            <ol>
               <li class="group-body">
                  Unless otherwise specified, the material on the Platform is presented solely for the purpose of sale in India. Kidsuperstore.in makes no representation that materials in the Platform are appropriate or available for use in other locations/Countries other than India. Those who choose to access Platform from other locations/Countries other than India do so on their own initiative and Kidsuperstore.in is not responsible for supply of products/refund for the products ordered from other locations/Countries other than India, compliance with local laws, if and to the extent local laws are applicable.
               </li>
            </ol>
         </div>                  

         <div class="points property mt-5">
            <h4 class="group-title">
               O. Intellectual Property Rights
            </h4>
            <ol>
               <li class="group-body">
                  Intellectual Property Rights (“IPR”) for the purpose of these Terms shall always mean and include Copyrights whether registered or not, Patents including rights of filing patents, Trademarks, Trade names, Trade dresses, House marks, Collective marks, Associate marks and the right to register them, designs both industrial and layout, geographical indicators, moral rights, source code, technical data, broadcasting rights, displaying rights, distribution rights, selling rights, abridged rights, translating rights, reproducing rights, performing rights, communicating rights, adapting rights, circulating rights, protected rights, joint rights, reciprocating rights, infringement rights and further shall also include but not be limited to all text, graphics, user interfaces, visual interfaces, sounds and music (if any), artwork and computer code in relation to the Website.
               </li>
               <li class="group-body">
                   All IPR on the Website exclusively belong to either the Website or the third party sellers and suppliers, as the case may be. Under no circumstance shall any User infringe in any way such IPR of the Website, a third party supplier or Seller during or pursuant to its use of the Website for any purposes whatsoever.
               </li>
               <li class="group-body">
                   All those IPR arising as a result of domain names, internet or any other right available under applicable law shall vest in the domain of Kidsuperstore.in and/or its affiliates as the owner of such domain name.
               </li>
               <li class="group-body">
                   The Parties hereto agree and confirm that no part of any Intellectual Property rights mentioned hereinabove is transferred in the name of User and any intellectual property rights arising as a result of these presents shall also be in the absolute ownership, possession and our control or control of its owners/permitted assigns, as the case may be.
               </li>
               <li class="group-body">
                   Every User hereby grants www.kidsuperstore.in a perpetual, non-revocable, worldwide, royalty-free and sub-licensable right and license to use, copy, publish, transmit, reproduce, modify, adapt any content provided or created by the User. Kidsuperstore.in shall have no liability for any infringement of intellectual property rights with respect to such content created by the User.
               </li>
               <li class="group-body">
                   Except as expressly provided herein, the User acknowledges and agrees that it shall not copy, republish, post, display, translate, transmit, reproduce or distribute or in any other way infringe any Intellectual Property Right through any medium without obtaining the necessary authorization from the Website or the thirty party owner of such Intellectual Property Right.
               </li>
            </ol>
         </div>      

         <div class="points indemnity mt-5">
            <h4 class="group-title">
               Q. Indemnity
            </h4>
            <ol>
               <li class="group-body">
                  The User hereby indemnifies, defends and holds harmless the entity owning and operating the Website, its affiliates, vendors, agents and their respective directors, officers, employees, contractors and agents (herein after individually and collectively referred to as "indemnified parties") from and against any and all losses, liabilities, claims, suits, proceedings, penalties, interests, damages, demands, costs and expenses (including legal and other statutory fees and disbursements in connection therewith and interest chargeable thereon) asserted against or incurred by the indemnified parties that arise out of, result from, or in connection with:
                  <ol class="lower-roman mt-3">
                     <li class="group-body">
                        The User’s breach of these Terms; or
                     </li>
                     <li class="group-body">
                        Any claims made by any third party due to, or arising out of, or in connection with, the User’s use of the Website; or
                     </li>
                     <li class="group-body">
                        Any claim that any third party IPR, proprietary information, content or materials provided by the User causes any damage to a third party; or
                     </li>
                     <li class="group-body">
                        Violation of any rights of any third party by the User, including any IPR. Each as “Indemnity Event”
                     </li>
                  </ol>
               </li>
               <li class="group-body">
                  Upon occurrence of an Indemnity Event, the Website may notify the User of any claims which the User shall be liable to indemnify the Website against. The User shall then be obligated to consult with the Website regarding the course of action to be undertaken in defending such a claim.
               </li>
               <li class="group-body">
                  The User shall not compromise or settle any claim or admit any liability or wrongdoing on the part of the Website without the express prior written consent of the Website which can be withheld or denied or conditioned by the Website in its sole discretion.
               </li>
               <li class="group-body">
                  Notwithstanding anything to contrary, the Website’s entire and aggregate liability to the User under and in relation to these Terms shall not exceed the greater of Indian Rupees One Hundred (INR 100) or the amount of fees, if any, paid by the User/Seller to the Website under the relevant order to which the cause of action for the liability relates.
               </li>
               <li class="group-body">
                  Notwithstanding anything to contrary, in no event shall the Website, its affiliates and their respective officers, directors, employees, partners or suppliers be liable to the User for any special, incidental, indirect, consequential, exemplary or punitive damages whatsoever, including those resulting from loss of use, data or profits, whether or not foreseeable or whether or not the Website has been advised of the possibility of such damages, or based on any theory of liability, including breach of contract or warranty, negligence or other tortious action, or any other claim arising out of or in connection with the User’s use of or access to the Website or the Product.
               </li>
            </ol>
         </div>    

         <div class="points resolution mt-5">
            <h4 class="group-title">
               R. Dispute Resolution
            </h4>
            <ol>
               <li class="group-body">
                 In the event any dispute arises out of or in connection with the Terms herein, the parties hereto shall endeavor to settle such dispute amicably in the first instance. The attempt to bring about an amicable settlement shall be treated as having failed as soon as one of the parties hereto, after reasonable attempts, which shall continue for not less than 20 calendar days, gives a notice to this effect, to the other party in writing.
               </li>
               <li class="group-body">
                 In the event any dispute arises out of or in connection with the Terms herein, the parties hereto shall endeavor to settle such dispute amicably in the first instance. The attempt to bring about an amicable settlement shall be treated as having failed as soon as one of the parties hereto, after reasonable attempts, which shall continue for not less than 20 calendar days, gives a notice to this effect, to the other party in writing.
               </li>
            </ol>
         </div>  

         <div class="points redressal mt-5">
            <h4 class="group-title">
               R. Dispute Resolution
            </h4>
            <ol>
               <li class="group-body">
                 At <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a>, we are committed towards ensuring that disputes between Sellers and Buyers are settled amicably by way of the above dispute resolution mechanisms and procedures. However, in the event that You wish to contact <a title="Kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">Kidsuperstore.in</a> about the seller You may write to us at <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a> The Website’s Users support team shall provide reasonable assistance and take such relevant actions against the Seller as it, at its sole discretion may deem fit.
               </li>
            </ol>
         </div>                               

         <div class="points resolution mt-5">
            <h4 class="group-title">
               T. Reporting of abuse
            </h4>
            <ol>
               <li class="group-body">
                  In the event the Website or any User becomes aware of any objectionable content on the Website including but not limited to violation of privacy, misuse of personal information or violation of any IPR, in violation of these Terms then, the Website, by itself or upon receipt of a communication from any of its Users, without any prior notice take down such objectionable content from the Website.
               </li>
               <li class="group-body">
                 For any reporting in respect of the aforesaid, the User should contact the Website at <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a>
               </li>
            </ol>
         </div>   
         
         <div class="points help mt-5">
            <h4 class="group-title">
               U. Help us
            </h4>
            <ol>
               <li class="group-body">
                  User feedbacks or information pertaining to Products offered on the Website or any information pertaining to the Website shall be deemed to be non-confidential in nature.
               </li>
               <li class="group-body">
                 The Website reserves the right, at its sole discretion to use such information for upgrading/enhancing the Website and such use shall be entirely unrestricted.
               </li>
               <li class="group-body">
                 The Website may at its discretion, also make any modifications or changes to the Website and its content and/or Products on the basis of such feedback or information.
               </li>
               <li class="group-body">
                 In the event that the Website makes any changes or modifications to the Website or Products on the basis of any such feedback, the User shall not have any rights or title (including any IPR) in such changes or modifications to the Website or Products listed therein.
               </li>
               <li class="group-body">
                 By submitting any feedback or any information, the User hereby warrants that the feedback does not contain confidential or proprietary information belonging to the User or any other person and shall not entitled to any compensation or reimbursement of any kind from the Website for the feedback under any circumstances.
               </li>
            </ol>
         </div>   

         <div class="points provisions mt-5">
            <h4 class="group-title">
               V. General Provisions
            </h4>
            <h5 class="group-title group-title--black">Force Majeure:</h5>
            <ol>
               <li class="group-body">
                 If performance of any Service under these Terms by the Website is prevented, restricted, delayed or interfered with by reason of labor disputes, strikes, acts of God, floods, lightning, severe weather, shortages of materials, rationing, inducement of any virus, Trojan or other disruptive mechanisms, any event of hacking or illegal usage of the website, utility or communication failures, earthquakes, war, revolution, acts of terrorism, civil commotion, acts of public enemies, blockade, embargo or any law, order, proclamation, regulation, ordinance, demand or requirement having legal effect of any government or any judicial authority or representative of any such government, or any other act whatsoever, whether similar or dissimilar to those referred to in this clause, which are beyond the reasonable control of the Website and could not have been prevented by reasonable precautions then the Website shall in to be excused and discharged from such performance to the extent of and during the period of such force majeure event, and such non-performance shall, in no manner whosoever, amount to a breach by the Website of its obligations herein.
               </li>
            </ol>
            <h5 class="group-title group-title--black mt-3">Notice:</h5>
            <ol>
               <li class="group-body">
                 Any notice to be sent to the Website pursuant to these Terms shall be sent to the Website’s grievance officer by e-mail to <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a>
               </li>
            </ol>
            <h5 class="group-title group-title--black mt-3">Assignment:</h5>
            <ol>
               <li class="group-body">
                 This Terms shall not be assigned or otherwise transferred by the User. However, the Website’s obligations under these Terms are freely assignable or otherwise transferable by the Website to any third parties without the requirement of seeking the Users prior consent.
               </li>
            </ol>
            <h5 class="group-title group-title--black mt-3">Severability:</h5>
            <ol>
               <li class="group-body">
                 If any provision of the Agreement is determined to be invalid or unenforceable in whole or in part, such invalidity or unenforceability shall attach only to such provision and the remaining part of such provision and all other provisions of the Agreement shall continue to be in full force and effect.
               </li>
            </ol>
            <h5 class="group-title group-title--black mt-3">Waiver:</h5>
            <ol>
               <li class="group-body">
                 Any failure or delay by a party to enforce or exercise any provision of these Terms, or any related right, shall not constitute a waiver by such party of that provision or right. The exercise of one or more of a party's rights hereunder shall not be a waiver of or preclude the exercise of, any rights or remedies available to such party under these Terms or in law or at equity. Any waiver by a party shall only be made in writing and executed by a duly authorized officer of such party.
               </li>
            </ol>
            <h5 class="group-title group-title--black mt-3">Relationship and Exclusivity:</h5>
            <ol>
               <li class="group-body">
                  Nothing in these Terms shall constitute or be deemed to constitute a partnership, joint venture, agency or the like between the parties hereto or confer on any party any authority to bind the other party or to contract in the name of the other party or to incur any liability or obligation on behalf of the other party.
               </li>
            </ol>
         </div>                              
      </div>
   </div>
</div>

@stop