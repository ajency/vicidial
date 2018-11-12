@extends('layouts.default')

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-4 bold mb-1 banner-title">Contact Us</h1>
      <h5 class="text-dark m-0">We'd Love to hear from you</h5>
   </div>
</div>
<div class="container mt-3">
   <!-- Breadcrumbs -->
   <div class="row">
      <div class="col-12">
         <div class="mb-4">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-1 bg-transparent p-0">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item" active><a href="#">Contact us</a></li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Stores -->
   <div class="row d-none d-sm-block">
      <div class="col-sm-12 my-4">
         <h3 class="line-height-5 font-weight-bold">Our help center is designed to answer question instantly; if you cannot find answers there or have any comments or suggestions we welcome you to contact us directly.</h3>
      </div>
   </div>
   <div class="row justify-content-center">
      <!-- Contact form -->
      <div class="col-sm-8 pb-3 pb-sm-5 pb-md-0 contactForm">
         <div class="row ml-0 p-md-4 mr-3 shadow no-shadow-mobile">
            <div class="col-md-12">
               <h4 class="text-center mb-sm-3 font-weight-bold">Send us a message to let us know how we can help</h4>
               <!--firstName-->
               <div class="form-group ">
                  <input class="form-control form-control-lg" id="names" type="text">
                  <label class="control-label">Name*</label>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group ">
                  <input class="form-control form-control-lg" id="mobile" type="text" >
                  <label class="control-label" >Mobile No*</label>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group ">
                  <input class="form-control form-control-lg" id="mobile" type="text" >
                  <label class="control-label" >Email*</label>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group ">
                  <input class="form-control form-control-lg" id="mobile" type="text" >
                  <label class="control-label" >Comments*</label>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group mt-3">
                  <button type="button" class="btn btn-primary btn-lg btn-block">Submit</button>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-4 mb-sm-3">
         <div class="row m-0">
            <div class="col-sm-12 shadow no-shadow-mobile p-sm-4 text-center">
               <img src="/img/envelope.png" alt="message" width="100" class="mb-2 mt-3">
               <h4 class="font-weight-bold d-block mb-4"> Send us an email</h4>
               <p class="h5 line-height-5">Message us directly and we aim to respond within 24hours. Our e-mail address is <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a></p>
            </div>
         </div>
      </div>
   </div>
</div>

@stop