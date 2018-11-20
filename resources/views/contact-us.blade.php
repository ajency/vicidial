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
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   <!-- Stores -->
   <div class="row">
      <div class="col-sm-6 border-right order-last order-md-first">
         <h2>Our Stores</h2>
         <div class="row mt-4">
            <div class="col-sm-6">
               <label class="font-weight-bold d-block">Surat:</label>
               G-5, Om Arcade, Opp. Green Elina,
               Anand Mahal Road,
               Adajan, Surat 395009
               Gujarat
            </div>
            <div class="col-sm-6 mt-5 mt-md-0">
               <label class="font-weight-bold d-block">Coimbatore:</label>
               97, DB Road,
               R.S. Puram, Coimbatore 641002
               Tamil Nadu
            </div>
         </div>
         <div class="row mt-5">
            <div class="col-sm-6">
               <label class="font-weight-bold d-block">Corporate Office:</label>
               Omni Edge Retail Pvt. Ltd.
               309, Autumn Grove, 
               Lokhandwala Township,
               Kandivali (East), Mumbai 400101
               Maharashtra
            </div>
            <div class="col-sm-6 mt-5 mt-md-0">
               <label class="font-weight-bold d-block">Registered Office:</label>
               Omni Edge Retail Pvt. Ltd.
               9th floor, Shop No. 912 and 914,
               Corporate Annexe,
               Sonawala Road,
               Goregaon East, Mumbai 400063
               Maharashtra
            </div>
         </div>
         <div class="row mt-5">
            <div class="col-md-12">
               <iframe src="https://www.google.com/maps/d/embed?mid=1nAfHzzG3YtLVbHvqoejmX4vfQI-mYHcY" width="100%" height="280"></iframe>
            </div>
         </div>
      </div>
      <!-- Contact form -->
      <div class="col-sm-6  order-first order-md-last pb-5 pb-md-0">
         <div class="row  p-md-5">
            <div class="col-md-12">
               <h2>Send us a message to let us know how we can help</h2>
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