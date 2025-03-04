@php 
			use Modules\Payment\Enums\PaymentMethodEnum;
	use Modules\Payment\Libraries\Onepay;
	use Illuminate\Support\Str;

	$onepay = new Onepay('international');
@endphp
<table border="1" cellspacing="0" cellpadding="0" style="width: 2400px">
	<thead>
		<tr>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Date
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Registration ID
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Title
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Full name
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Affiliation
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Position
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Country/Region
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Passport
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Phone No.
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Email
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Galadinner
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Dietary
				</p>
			</td>
			<td width="500px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Category
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Fee
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Attach
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Trans.ID
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Payment method
				</p>
			</td>
			<td width="200px" valign="top" style="width: 200px; background-color: #95a5a6;">
				<p align="center">Payment status
				</p>
			</td>
		</tr>
	</thead>
	<tbody>
		@if($registrations->isNotEmpty())
			@foreach($registrations as $registration)
				<tr>
					<td width="200px" valign="top">
						<p>
							{{ $registration->registered_at }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->guest_code }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->title }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->fullname }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->affiliation }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->position }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->country }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							@if($registration->passport) <a href="{{ get_image_url($registration->passport) }}">Download</a>
							@endif
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->phone }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->email }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->galadinner }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->dietary }}
						</p>
					</td>
					<td width="500px" valign="top">
						<p>
							{{ $registration->conference_type }}

						</p>
					</td>
					<td>
						@php
							//dd($registration->conference_fees);
							$registrationFeeData = $registration->conference_fees;

							if (empty($registrationFeeData)) {
								echo 'No conference fee data provided';
								return;
							}

							$registrationFeeId = (int) json_decode($registrationFeeData);

							$conferenceFees = conferenceFeesById();

							if (isset($conferenceFees[$registrationFeeId])) {
								echo htmlspecialchars($conferenceFees[$registrationFeeId]['name'], ENT_QUOTES, 'UTF-8');
							} else {
								echo 'Name not found for the given fee ID';
							}
						@endphp
					</td>
					<td width="200px" valign="top">
						<p>
							@if($registration->attach) <a href="{{ get_image_url($registration->attach) }}">Download</a> @endif
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->vpc_TransactionNo ?? '' }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->totalFormatted }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							{{ $registration->payment_method }}
						</p>
					</td>
					<td width="200px" valign="top">
						<p>
							@php 
																							if ($registration->payment_method == PaymentMethodEnum::ONEPAY_PAYMENT) {
									$paymentStatus = $registration->status == 'pending' ? $onepay->getResponseDescription($registration->txnResponseCode) : $registration->status;
								} else {
									$paymentStatus = $registration->status;
								}

								echo $registration->paymentStatus($paymentStatus);
							@endphp
						</p>
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>