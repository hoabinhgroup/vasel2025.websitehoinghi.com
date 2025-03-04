@php
	use Illuminate\Support\Str;
@endphp
<table border="1" cellspacing="0" cellpadding="0" style="width: 2000px">
	<thead>
		<tr>
			@php
				$columns = [
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
				<tr>
					<td>{{ $registration->guest_code }}</td>
					<td>{{ $registration->title }}</td>
					<td>{{ $registration->fullname }}</td>
					<td>{{ $registration->work }}</td>
					<td>{{ $registration->jobtitle }}</td>
					<td>{{ $registration->address }}</td>
					<td>{{ $registration->email }}</td>
					<td>{{ $registration->phone }}</td>
					<td>{{ $registration->cid }}</td>
					<td>{{ $registration->gender }}</td>
					<td>{{ $registration->birthday }}</td>
					<td>{{ $registration->birthmonth }}</td>
					<td>{{ $registration->birthyear }}</td>
					<td>{{ $registration->training }}</td>
					<td>{{ $registration->galadinner }}</td>
					<td>{{ $registration->course }}</td>
					<td>{{ $registration->experience }}</td>
					<td>{{ $registration->course_name }}</td>
					<td>{{ $registration->form_invitation }}</td>
					<td>{{ $registration->form_certificate}}</td>
					<td>{{ $registration->payment_form }}</td>
					<td>{{ $registration->payment_method }}</td>
					<td>
						@if($registration->unc_statement)
							<a href="{{ get_image_url($registration->unc_statement) }}">Download</a>
						@endif
					</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>