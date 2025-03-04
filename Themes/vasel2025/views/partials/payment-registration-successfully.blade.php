@extends('theme::layouts.master')
@section('content')
<header class="grid">
	<div class="s-12 padding-2x">
		<h1 class="text-strong text-dark text-center center text-size-60 text-uppercase margin-bottom-20">Registration
			Successfully</h1>
	</div>
</header>
<style>
	table{
		border: 1px solid #000;
	}
	table tr td{
		padding: 0px 0px 0px 20px;
	}
</style>
<section class="grid margin-bottom-20">
	<div class="m-12 l-7 center">
		<!-- Contact Information-->
		<p style="text-align: center;">Thank you for registering for the 19th Annual Scientific Meeting of Asia Pacific
			Society of Cardiovascular and Interventional Radiology (APSCVIR 2025)</p>
		<p style="text-align: center;">Your registration ID is {{ $guest_code }} Please keep the registration number for
			your records.</p>
		<p style="text-align: center;">The registration number is required for all communications with APSCVIR 2025
			regarding this registration.</p>
		<p style="text-align: center;"> </p>
		<p style="text-align: center;">Please transfer the conference fee:</p>
		<table style="border-collapse: collapse; width: 700px; margin-left: auto; margin-right: auto;">
			<tbody>
				<tr>
					<td width="510">
						<p><strong>Wire Transfer</strong> <em>(Bank charges must be paid at your expense)</em></p>
					</td>
					<td rowspan="7" width="132"><img src="https://cdn.websitehoinghi.com/apscvir25/qr-transfer.png"
							width="176" height="228" alt="" /></td>
				</tr>
				<tr>
					<td width="510">
						<p>Account Holder:     HOA BINH INTERNATIONAL TOUR CO., LTD</p>
					</td>
				</tr>
				<tr>
					<td width="510">
						<p>Account Number:  0011.0033.12740 (VND)</p>
						<p>                              0011.3733.12796 (USD)</p>
					</td>
				</tr>
				<tr>
					<td width="510">
						<p>Bank:                     Vietcombank</p>
					</td>
				</tr>
				<tr>
					<td width="510">
						<p>Bank address:       Vietcombank – 31 – 33 Ngo Quyen Street, Hoan Kiem district, Hanoi</p>
					</td>
				</tr>
				<tr>
					<td width="510">
						<p>Citad:                     01203001</p>
					</td>
				</tr>
				<tr>
					<td width="510">
						<p>SWIFT code:          BFTVVNVX001</p>
					</td>
				</tr>
			</tbody>
		</table>
		<p style="text-align: center;"> </p>
		<p style="text-align: center;">Please indicate, "|Full name – Registration ID| paid for APSCVIR 2025”</p>
		<p style="text-align: center;">as a reference and send proof of bank transfer to <a
				href="mailto:iwamsn2024@ims.vast.ac.vn">vsir.radiology@gmail.com / apscvir2025.secretariat@gmail.com</a>
		</p>
	</div>
</section>
@endsection