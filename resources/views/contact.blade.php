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
      <div class="col-sm-12 text-center my-4">
         <h3 class="text-gray">Our help center is designed to answer question instantly; if you cannot find answers there or have any comments or suggestions we welcome you to contact us directly.</h3>
      </div>
   </div>
   <div class="row justify-content-center">
      <div class="col-sm-12 order-last order-md-first mb-sm-3">
         <div class="row mt-sm-4">
            <div class="col-sm-12 mb-2 mb-sm-3 text-center">
               <h4 class="font-weight-bold d-block mb-sm-3"><i class="far fa-envelope"></i> Send us an email</h4>
               <p class="h5 kss-title">Message us directly and we aim to respond within 24hours. Our e-mail address is <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a></p>
            </div>
         </div>
      </div>
      <!-- Contact form -->
      <div class="col-sm-8 order-first order-md-last pb-3 pb-sm-5 pb-md-0 shadow contactForm">
         <div class="row p-md-4">
            <div class="col-md-12">
               <h3 class="text-center mb-sm-3">Send us a message to let us know how we can help</h3>
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
   </div>
</div>

@stop