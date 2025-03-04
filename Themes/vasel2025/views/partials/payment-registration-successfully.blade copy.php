@extends('theme::layouts.master')
@section('content')
<header class="grid">
	<div class="s-12 padding-2x">
	<h1 class="text-strong text-dark text-center center text-size-60 text-uppercase margin-bottom-20">Registration Successfully</h1>
  </div>
</header>
<section class="grid margin-bottom-20">
  <div class="m-12 l-7 center">
	<!-- Contact Information-->
	<div class="s-12 padding-2x background-white text-center">
	<p class="MsoListParagraphCxSpFirst"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><span style="font-size: 12pt; font-family: Cambria, serif;">Thank you for registering for</span></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">the 11th International Workshop
				on</span></strong></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Advanced Materials Science and
				Nanotechnology</span></strong></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><span style="font-size: 12pt; font-family: Cambria, serif;">Your registration ID is
			</span><span style="font-size: 12pt; font-family: Cambria, serif;"> {{ $guest_code }}</span><span
			style="font-size: 12pt; font-family: Cambria, serif;">. Please keep the registration number for your
			records.</span></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><span style="font-size: 12pt; font-family: Cambria, serif;">The registration number is required for
			all communications with IWAMSN 2024 regarding this registration.</span></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><span style="font-size: 12pt; font-family: Cambria, serif;"> </span></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><span style="font-size: 12pt; font-family: Cambria, serif;">Please transfer the conference fee – {{ $total }}
			USD</span><span style="font-size: 12pt; font-family: Cambria, serif;"><a name="Text15"></a> </span><span
			style="font-size: 12pt; font-family: Cambria, serif;"> to following bank:</span></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Account Holder: HOA BINH
				INTERNATIONAL TOUR CO., LTD</span></strong></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Account number:
			</span></strong><strong><span style="font-size: 12pt; font-family: Cambria, serif;">0011.3733.12796 (USD) -
				0011.0033.12740 (VND)</span></strong></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Bank: Vietcombank – 31 – 33 Ngo
				Quyen Street, Hoan Kiem district, Hanoi</span></strong></p>
	<p class="MsoListParagraphCxSpMiddle"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Citad: 01203001</span></strong>
	</p>
	<p class="MsoListParagraphCxSpLast"
		style="margin: 3pt 0in; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; text-align: center; background: white;"
		align="center"><strong><span style="font-size: 12pt; font-family: Cambria, serif;">Swift code:
				BFTVVNVX001</span></strong></p>
	<p class="MsoNormal"
		style="margin: 3pt 0in; text-align: justify; line-height: normal; font-size: 11pt; font-family: Calibri, sans-serif; background: white;">
		<em><u><span style="font-size: 12pt; font-family: Cambria, serif;">Please indicate, "|Full name – Registration ID|
					paid for IWAMSN 2024” as reference and send proof of bank transfer to </span></u></em><a
			name="Text19" href="mailto:iwamsn2024@ims.vast.ac.vn">iwamsn2024@ims.vast.ac.vn</a>  <u></u></p>
	</div>
  </div>
</section>
@endsection