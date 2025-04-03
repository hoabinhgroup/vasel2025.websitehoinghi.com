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
					'Guest Code',
					'Học hàm học vị',
					'Họ và tên',
					'Đơn vị công tác',
					'Chức vụ',
					'Địa chỉ',
					'Email',
					'Phone',
					'CMND/CCCD/HỘ CHIẾU',
					'Giới tính',
					'Ngày sinh',
					'Tháng snh',
					'Năm sinh',
					'Đăng ký tham dự tập huấn tiền hội nghị',
					'ĐĂNG ký tham dự tiệc chiêu đãi hội nghị',
					'Chuyên khoa',
					'Số năm kn',
					'Đăng ký các khóa',
					'Hình thức nhận giấy mời',
					'Hình thức nhận chứng nhận',
					'Hình thức thanh toán',
					'Phương thức thanh toán',
					'Sao kê thanh toán',
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
					$lastAudit = $registration->audits()
        ->where('event', 'updated')
        ->latest()
        ->first();

	
	$latestFields = [];

	if ($lastAudit && $lastAudit->new_values) {
		foreach ($lastAudit->new_values as $field => $newValue) {
			$latestFields[$field] = [
				'old' => $lastAudit->old_values[$field] ?? null,
				'new' => $newValue,
			];
		}
	}

	$registration->latest_updated_fields = $latestFields;
    $registration->latest_updated_at = $lastAudit && $lastAudit->created_at ? $lastAudit->created_at->format('d/m/Y H:i'): null;
				@endphp
				<tr>
					<td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
					<td>{{ $registration->latest_updated_at }}</td>
					<td>{!! showChangedValue($registration, 'guest_code') !!}</td>
					<td>{!! showChangedValue($registration, 'title') !!}</td>
					<td>{!! showChangedValue($registration, 'fullname') !!}</td>
					<td>{!! showChangedValue($registration, 'work') !!}</td>
					<td>{!! showChangedValue($registration, 'jobtitle') !!}</td>
					<td>{!! showChangedValue($registration, 'address') !!}</td>
					<td>{!! showChangedValue($registration, 'email') !!}</td>
					<td>{!! showChangedValue($registration, 'phone') !!}</td>
					<td>{!! showChangedValue($registration, 'cid') !!}</td>
					<td>{!! showChangedValue($registration, 'gender') !!}</td>
					<td>{!! showChangedValue($registration, 'birthday') !!}</td>
					<td>{!! showChangedValue($registration, 'birthmonth') !!}</td>
					<td>{!! showChangedValue($registration, 'birthyear') !!}</td>
					<td>{!! showChangedValue($registration, 'training') !!}</td>
					<td>{!! showChangedValue($registration, 'galadinner') !!}</td>
					<td>{!! showChangedValue($registration, 'course') !!}</td>
					<td>{!! showChangedValue($registration, 'experience') !!}</td>
					<td>{!! showChangedValue($registration, 'course_name') !!}</td>
					<td>{!! showChangedValue($registration, 'form_invitation') !!}</td>
					<td>{!! showChangedValue($registration, 'form_certificate') !!}</td>
					<td>{!! showChangedValue($registration, 'payment_form') !!}</td>
					<td>{!! showChangedValue($registration, 'payment_method') !!}</td>
					<td>
						{!! showChangedValue($registration, 'unc_statement', true) !!}
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>