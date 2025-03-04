@extends('theme::layouts.master')
@section('content')
@php
use Modules\Payment\Enums\PaymentMethodEnum;
@endphp
<style>
.general-information-title{
	display: flex;
}

form h4, form h4 label{
	margin-bottom: 0px !important;
}

#totalData{
	width: 1px;
	height: 1px;
	background: transparent;
	border:none;
}

.registration_section{
	display: flex;
}

td.total-data{
	width: 100%;
}

.other-specify input#titleOther{
	position: relative;
}

.other-specify {
	display: flex;
	align-items: center;
}

.general-information-title{
	align-items: center;
}

#conference_checklist{
	height: 1px;
}

label{
	width: 20%;
	font-size: 14px;
	font-weight: bold;
	text-transform: uppercase;
}

.row .col-md-3{
	width:35%;
	text-align: left;
}

.dietary-wrapper{
	display: flex;
	min-height: 50px;
}

.dietary-wrapper .radio-inline{
	padding-top: 0px;
	display: flex;
	align-items: center;
	column-gap: 5px;
}


#dietary-error{
	position: absolute;
}

#conference-fee-table thead th, #conference-fee-table tr td {
	border: 1px solid #000;
	padding: 10px;
}


#conference_checklist_item-error{
	padding-left: 20px;
}

#conference-fee-table{
	margin: 20px;
}

#conference_checklist_item_error .form-group{
	margin-bottom: 0px;
}

#conference_checklist_item-error{
	color: red;
}

.quantity-person{
	display: flex;
	align-items: center;
	border-top: none !important;
	border-right: none !important;
}

.quantity-person input{
	width: 50px;
	height: 30px;
	margin-left: 15px;
}

tfoot tr td{
	border: none !important;
}
#total-label{
	text-align: right;
	color: red;
	font-weight: bold;
}

</style>

<header class="grid header-grid">
	<div class="s-12 padding-2x">
	<h1 class="text-strong text-dark text-center center text-size-60 text-uppercase margin-bottom-20">REGISTRATION FORM <br/> FOR
	RESEARCHERS/ STUDENTS/ ATTENDEES
</h1>
  </div>
</header>
<section class="grid margin-bottom-20">
  <div class="m-12 l-9 center">
	<!-- Contact Information-->
	<div class="s-12 padding-2x background-white text-center">
	
		<input type="hidden" name="id" value="{{ $registration->id }}">
		<div id="registration_heading">
			<center>
	
				<i>Please complete the following details to submit your request.</i>
			</center>
			<hr>
	
		</div>
		<div class="form-group">
		
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="input-type">Title:</label>
				</div>
				<div class="col-md-9">
					<div class="row no-gutters general-information-title">
						{{ $registration->title == 5 ? $registration->titleOther : $registration->title }}
		
					</div><!-- .row -->
		
				</div>
			</div>
		
		
		</div>
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Full name:</label>
				</div>
				<div class="col-md-9">
					{{ $registration->fullname }}
		
				</div><!-- .row -->
		
			</div><!-- .row -->
		</div>
		
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Affiliation:</label>
				</div>
				<div class="col-md-9">
					{{ $registration->affiliation }}
		
				</div>
			</div><!-- .row -->
		
		</div>
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Position:</label>
				</div>
				<div class="col-md-9">
					{{ $registration->position }}
		
				</div>
			</div><!-- .row -->
		
		</div>
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Country/Region:</label>
				</div>
				<div class="col-md-9">
					{{ allCountries()[$registration->country] }}
					
				</div>
			</div><!-- .row -->
		
		</div>
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Mobile Number:</label>
				</div>
				<div class="col-md-9">
					{{ $registration->mobiphone }}
				</div>
			</div><!-- .row -->
		</div>
		
		<div class="form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Email:</label>
				</div>
				<div class="col-md-9">
					{{ auth()->guard('member')->user()->email ?? $registration->email }}
				</div>
			</div><!-- .row -->
		</div>
		
		<div class="form-group">
			<div class="row no-gutters dietary-wrapper">
				<div class="col-md-3">
					<label for="">Special dietary requirements:</label>
				</div>
				<div class="col-md-9">
					
					{{ $registration->dietary }}
				
				</div>
				
			</div><!-- .row -->
		</div>
		
	
	
	
		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
					<h4><label style="margin: 15px 0px;color: blue" for="">
							CONFERENCE FEE:</label></h4>
				</div>
			</div>
			<div class="form-group">
				<div class="row no-gutters vps-member-wrapper">
					<div class="col-md-3">
						<label for=""><strong>VPS/V-MRS member</strong>:</label>
					</div>
					<div class="col-md-9">
						
						{{ $registration->is_vps_member ? 'Yes':'No' }}
					
					</div>
					
				</div><!-- .row -->
				<div class="row">
				</div>
			</div>
			@php 
			
			$conferenceFees = json_decode($registration->conference_fees);
			
			@endphp
			<div class="form-group">
			<div class="row no-gutters vps-member-wrapper">
				
				<div class="col-md-3">
					<label for=""><strong>Conference Fee Category</strong>:</label>
				</div>
				<div class="col-md-9">
					
					{{ conferenceFees()[$conferenceFees->id]['category'] }}
				
				</div>
			
			
			</div>
			</div>
			
			<div class="form-group">
			<div class="row no-gutters">
				
				<div class="col-md-3">
					<label for=""><strong>Conference Fee total</strong>:</label>
				</div>
				<div class="col-md-9">
					
					{{ number_format($conferenceFees->amount) }} {{ $conferenceFees->unit }}
				
				</div>
			
			
			</div>
			</div>
		
		
		@if($conferenceFees->id == 1)
		<div class="attach_section form-group">
			<div class="row no-gutters">
				<div class="col-md-3">
					<label for="">Student ID Card.:</label>
				</div>
				<div class="col-md-9">
					<a href="/storage/{{ $registration->attach }}">Download</a>
				
				</div>
			</div>
		</div>
		@endif
	
		<div class="form-group">
			<div class="row">
				<div class="col-md-3">
					<h4><label style="margin: 15px 0px;color: blue" for="">
							PAYMENT METHOD:</label></h4>
				</div>
				<div class="col-md-9">
							{{ $registration->payment_method }}
				</div>
			</div>
		</div>
	
		<div class="registration_section form-group">
			<a href="/payment-registration-page" class="s-12 m-9 l-2 center button text-size-20 text-white background-green">BACK</a>
			<a href="{{ route('payment.registration.submit') }}" class="s-12 m-9 l-2 center button text-size-20 text-white background-green">SUBMIT</a>
		
		</div>
	
	
	</div>

  </div>                  

</section>

	
@endsection