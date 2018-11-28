@extends('layouts.default')

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-4 bold mb-1 banner-title">Privacy Policy</h1>
   </div>
</div>
<div class="container mt-sm-3">
   <!-- Breadcrumbs -->
   <div class="row mt-2 mt-sm-2">
      <div class="col-12">
         <div class="mb-4">
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   
   <div class="row justify-content-center bg-lightgray p-sm-5">
      <div class="col-sm-12 mb-sm-3">
         <div class="points about mt-3">
            <h4 class="group-title">
               A. Who is Kidsuper Store?
            </h4>
            <ol>
               <li class="group-body">
                  Omni Edge Retail Private Limited, a Company incorporated under the various applicable laws of India and having its Registered Office at 912 and 914, Corporate Annexe, Sonawala Road, Goregaon (East), Mumbai 400063, Maharashtra, India (“Kidsuper Store”) is a retail Company which offers various fashion and accessories solutions, through its website <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in" target="_blank">www.kidsuperstore.in</a> and its mobile and tablet application which inter alia facilitate the sale and purchase of fashion and accessories (“Products”) by users of the Platforms (“Users”).
               </li>
            </ol>
         </div>

         <div class="points membership mt-5">
            <h4 class="group-title">
               B. What is this Privacy Policy about?
            </h4>
            <ol>
               <li class="group-body">
                  Data protection is a matter of trust and your privacy is important to us. This Privacy Policy along with the Terms and Conditions describes the procedures and policies of Kidsuper Store on the collection, use and sharing/disclosure of information provided by Users and Visitors/Guest users on the platform. We will only collect information where it is necessary for us to do so and we will only collect information if it is relevant to our dealings with you. We appreciate that you care about how your information is used and secured at our end. We value the trust you place in us and are committed to handling your data with the required level of confidentiality. We employ the highest standards for secure transactions and customer information privacy. Please read the following policy statement to learn more. We shall never use the information provided to us by Users in any manner except as provided under this Privacy Policy.
               </li>
            </ol>
         </div>

         <div class="points account mt-5">
            <h4 class="group-title">
               C. Why this Privacy Policy?
            </h4>
            <ol>             
               <li class="group-body">
                  This Privacy Policy is published pursuant to:
                  <ol class="lower-roman my-3">
                     <li class="group-body">
                        Section 43A of the Information Technology Act, 2000;
                     </li>
                     <li class="group-body">
                        Regulation 4 of the Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Information) Rules, 2011 (“SPI Rules”); and
                     </li>
                     <li class="group-body">
                        Regulation 3(1) of the Information Technology (Intermediaries Guidelines) Rules, 2011.
                     </li>
                  </ol>
                  This Privacy Policy sets out the type of information collected from the Users, including the nature of the sensitive personal data or information, the purpose, means and modes of usage of such information and how and to whom Kidsuper Store shall disclose such information
               </li>
            </ol>
         </div>         

         <div class="points services mt-5">
            <h4 class="group-title">
               D. Applicability and Confidentiality:
            </h4>
            <ol>           
               <li class="group-body">
                  This Privacy Policy applies to customers' Users Account Information only. We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may release your information to comply with applicable law or to abide by any order from appropriate authority, enforce our site policies, or protect our interest if necessary. However, non-personal identifiable information may be provided, to other parties for marketing, advertising, or other uses as permitted by law.
               </li>
            </ol>
         </div>    

         <div class="points obligations mt-5">
            <h4 class="group-title">
               E. What does Sensitive Personal Data or Information include?
            </h4>
            <ol>
               <li class="group-body">
                  As per the definition prescribed under the SPI Rules, Personal Data or Information shall include such personal information about the concerned person which shall relate to his:
                  <ol class="lower-roman my-3">
                     <li class="group-body">
                        Passwords;
                     </li>
                     <li class="group-body">
                        Financial information such as bank accounts, credit and debit card details or other payment instrument details;
                     </li>
                     <li class="group-body">
                        Physical, physiological and mental health condition;
                     </li>
                     <li class="group-body">
                        Sexual orientation;
                     </li>
                     <li class="group-body">
                        Medical records and history;
                     </li>
                     <li class="group-body">
                        Biometric information; and
                     </li>
                     <li class="group-body">
                        Information received by body corporates under lawful contract or otherwise.
                     </li>
                  </ol>
                  Certain information provided by Users may allow for personal identification of the Users, including email addresses, telephone numbers and other contact information. It may be noted that any information that is freely available in the public domain or accessible under the Right to Information Act, 2005, or any other law will not be regarded as sensitive personal data or information, or as personally identifiable information.
               </li>
            </ol>
         </div>  

         <div class="points listing mt-5">
            <h4 class="group-title">
               F. How do we receive your Information?
            </h4>
            <ol>
               <li class="group-body">
                  You can visit the Website and browse without having to provide personal details. During your visit to the Website you remain anonymous and at no time can we identify you unless you have an account on the Website and log on with your user name and password. We receive information from you when you register on our website <a title="www.kidsuperstore.in" href="https://www.kidsuperstore.in/" target="_blank">www.kidsuperstore.in</a> or our mobile app, subscribe to our product updates, or fill out a form sharing your personal data. When ordering or registering on our site, you may be requested to share your name, e-mail address or phone number.
               </li>
            </ol>
         </div>                      

         <div class="points products mt-5">
            <h4 class="group-title">
               G. What do we do with the Information?
            </h4>
            <ol>
               <li class="group-body">
                  We collect, store and process your data for processing your purchase on the Website and any possible later claims, and to provide you with our services. We may collect your title, name, gender, email address, postal address, delivery address (if different), telephone number, mobile number, fax number, payment details, payment card details or bank account details, Internet Protocol (IP) address, personal information received from social networking sites through which you have registered to the Website including name, profile picture, email address or friends list, and any information made public in connection with that social media service and such other personal and non-personal information that may be required to access and operate the Website. We may also use your data in order to manage the Website, collect payments from you, enable you to subsequently use parts of the Website, detect any fraud or Website abuses, send Users information relevant to the Website or our products, and in case we have any queries. Payments that you make through the Website will be processed by Omni Edge Retail Private Limited. We will only keep your information for as long as we are either required to by law or as is relevant for the purposes for which it was collected. The Website shall use the information collected from Users in accordance with applicable laws including but not limited to the Information Technology Act, 2000 and the rules made thereunder and use the data only for the purpose of completing the transaction or for purposes as may be required under the laws. We may collect various information if you seek to place an order for a product with us on the Website. Please be advised that the duration of use of the Website by Users may also be logged and stored by the Website. The information may be collected and/or stored in electronic form. However, we are hereby authorized by Users to collect/store such information is physical form as well.
               </li>
            </ol>
         </div>     

         <div class="points listing mt-5">
            <h4 class="group-title">
               H. Why do need such information?
            </h4>
            <ol>
               <li class="group-body">
                  To identify the User, to understand his/her/its needs and resolve disputes, if any;
               </li>
               <li class="group-body">
                  To set up, manage and offer products and to enhance the Services to meet the User’s requirements;
               </li>
               <li class="group-body">
                  We need this information in order to allow you to go ahead with placing your order for a product;
               </li>
               <li class="group-body">
                  We may use that data to process payment for the product and deliver the product to you;
               </li>
               <li class="group-body">
                  To customize User experience;
               </li>
               <li class="group-body">
                  We also use that data to inform you when the product is about to be delivered;
               </li>
               <li class="group-body">
                  We may share the information collected from Users with our affiliates, employees, service provider, sellers, suppliers, banks, payment gateway operators and such other individuals and institutions like judicial, quasi-judicial law enforcement agencies.
               </li>
               <li class="group-body">
                  We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier);
               </li>
               <li class="group-body">
                  Your actual order details may also be stored with us and you may access this information by logging into your account on the Website. Here you can view the details of your orders that have been completed, those which are open and those which are to be dispatched, and administer your address details, bank details and any newsletter to which you may have subscribed.
               </li>
               <li class="group-body">
                  You undertake to treat the personal access data confidentially and not make it available to unauthorized third parties. We cannot assume any liability for misuse of passwords unless this misuse is our fault.
               </li>               
            </ol>
         </div>         

         <div class="points delivery mt-5" id="shipping">
            <h4 class="group-title">
               I. Security of Information
            </h4>
            <ol>
               <li class="group-body">
                  We take appropriate precautions to protect the security of sensitive Personal Data or Information.
               </li>
               <li class="group-body">
                  We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Website.
               </li>
               <li class="group-body">
                  We shall not share any of your personal information with third parties without your explicit consent.
               </li>
               <li class="group-body">
                  We view protection of your privacy as a very important community principle.
               </li>
               <li class="group-body">
                  We recommend that you do not share your password with anyone.
               </li>
               <li class="group-body">
                  We understand clearly that you and your information is one of our most important assets. We store and process your information on computers located in India that are protected by physical as well as technological security devices.
               </li>
               <li class="group-body">
                  We use third parties to verify and certify our privacy principles. If you object to your information being transferred or used in this way please do not use the Website.
               </li>
               <li class="group-body">
                  Under no circumstances do we rent, trade or share your personal information that we have collected with any other company for their marketing purposes without your consent. We reserve the right to communicate your personal information to any third party that makes a legally-compliant request for its disclosure.
               </li>
               <li class="group-body">
                  Notwithstanding anything to the contrary, the Website shall not be held responsible for any loss, damage or misuse of the information provided by you.
               </li>
               <li class="group-body">
                  When you download or use Kidsuper Store mobile apps, we may receive information about your location and your mobile device, including a unique identifier for your device.
               </li>
               <li class="group-body">
                  We may use this information to provide you with location-based services, such as advertising, search results, and other personalized content. You can also turn off the location services using your mobile phone settings.
               </li>
               <li class="group-body">
                   When you download or use Kidsuper Store mobile apps, we also collect various device-specific details like Device ID, Device Contacts, and Device Accounts including third-party accounts or MAC-address. This data is used to resolve technical difficulties and to provide you with the correct and most recent version of our mobile apps.
               </li>
            </ol>
         </div>                  

         <div class="points refund mt-5" id="return">
            <h4 class="group-title">
               J. Users Note
            </h4>
            <ol>
               <li class="group-body">
                   By accessing or using the Platforms and all other services provided by Kidsuper Store to its Users it shall mean that the User has accepted the Terms and Conditions which also involves acceptance of this Privacy Policy. Any User who does not agree with any of the provisions of the Terms and Conditions or this Privacy Policy may leave the Platforms. You hereby represent and warrant to the Website that:
                   <ol class="lower-roman mt-3">
                     <li class="group-body">
                        All information derived from in relation to you are true, correct, current and updated.
                     </li>
                     <li class="group-body">
                        All information given does not belong to any third party, and if it does belong to a third party, you are authorized by such third party to use, access and disseminate such information.
                     </li>
                  </ol>
               </li>
            </ol>
         </div> 

         <div class="points cancellation mt-5" id="cancellation">
            <h4 class="group-title">
               K. Third Party Links
            </h4>
            <ol>
               <li class="group-body">
                 While shopping online you could sometimes access third party products or services. These links and offers on third party sites have separate and independent privacy policies. Kidsuper Store has no responsibility or liability for the content and activities of these linked sites, if any. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.
               </li>             
            </ol>
         </div>   

         <div class="points content-use mt-5">
            <h4 class="group-title">
               L. Minors Accessing the Website
            </h4>
            <ol>
               <li class="group-body">
                  Kidsuper Store shall not be held liable for any transactions done on the website by a minor representing that he/she is a major. Contracts entered by minors are void ab initio as per Indian law.
               </li>
            </ol>
         </div>                             

         <div class="points links mt-5">
            <h4 class="group-title">
               M. Amendment to the Policy
            </h4>
            <ol>
               <li class="group-body">
                  Kidsuper Store reserves the right to change the Policy to its business requirements. We will post those changes on this site as and when modified. Do frequent this website to access the updated Privacy Policy as modified from time to time.
               </li>
            </ol>
         </div>   

         <div class="points sales mt-5">
            <h4 class="group-title">
               N. Cookies
            </h4>
            <ol>
               <li class="group-body">
                  A "cookie" is a small piece of information stored by a web server on a web browser so it can be later read back from that browser. Cookies are useful for enabling the browser to remember information specific to a given user. We place both permanent and temporary cookies in your computer's hard drive. The cookies do not contain any of your personally identifiable information. We use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, keep track of advertisements and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.
               </li>
            </ol>
         </div>                                               
      </div>
   </div>
</div>

@stop