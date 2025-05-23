@php
	use Illuminate\Support\Str;
@endphp
<table border="1" cellspacing="0" cellpadding="0" style="width: 2000px">
	<thead>
		<tr>
			@php
				$columns = [
					'Ngày đăng ký',
					'Ngày chỉnh sửa',
					'ID',
					'Title',
					'Full Name',
					'Organization',
					'Position',
					'Address',
					'Email',
					'Phone',
					'Short CV',
					'Passport',
					'Gender',
					'Date',
					'Month',
					'Year',
					'Pre-Conference Workshop',
					'Specialized In',
					'Years of Experience',
					'Workshop',
					'Gala Dinner',
					'Payment method',
					'Form of payment'
				];
			@endphp

			@foreach ($columns as $column)
				<td width="200px" valign="top" style="background-color: #95a5a6;">
					<p align="center">{{ $column }}</p>
				</td>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@if($registrations->isNotEmpty())
			@foreach($registrations as $registration)
				@php

					$lastAudit = getLastAudit($registration);
					$shortCV = getDownloadLink($registration, 'shortCV', 'Download');
					$passport = getDownloadLink($registration, 'passport', 'Download');

					$registration->latest_updated_fields = getLatestFields($lastAudit);
					$registration->latest_updated_at = $lastAudit && $lastAudit->created_at
						? $lastAudit->created_at->format('d/m/Y H:i')
						: null;
				@endphp
				<tr>
					<td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
					<td>{{ $registration->latest_updated_at }}</td>
					<td>{{ $registration->guest_code }}</td>
					<td>{!! showChangedValue($registration, 'title') !!}</td>
					<td>{!! showChangedValue($registration, 'fullname') !!}</td>

					<td>{!! showChangedValue($registration, 'organization') !!}</td>
					<td>{!! showChangedValue($registration, 'work') !!}</td>
					<td>{!! showChangedValue($registration, 'address') !!}</td>
					<td>{!! showChangedValue($registration, 'email') !!}</td>
					<td>{!! showChangedValue($registration, 'phone') !!}</td>
					<td>
						{!! $shortCV !!}
					</td>
					<td>
						{!! $passport !!}
					</td>
					<td>{!! showChangedValue($registration, 'gender') !!}</td>
					<td>{!! showChangedValue($registration, 'birthday') !!}</td>
					<td>{!! showChangedValue($registration, 'birthmonth') !!}</td>
					<td>{!! showChangedValue($registration, 'birthyear') !!}</td>
					<td>{!! showChangedValue($registration, 'training') !!}</td>
					<td>{!! showChangedValue($registration, 'course') !!}</td>
					<td>{!! showChangedValue($registration, 'experience') !!}</td>
					<td>{!! showChangedValue($registration, 'course_name') !!}</td>
					<td>{!! showChangedValue($registration, 'galadinner') !!}</td>
					<td>{!! showChangedValue($registration, 'payment_form') !!}</td>
					<td>{!! showChangedValue($registration, 'payment_method') !!}</td>

				</tr>
			@endforeach
		@endif
	</tbody>
</table>