@php
	use Illuminate\Support\Str;
@endphp
<table border="1" cellspacing="0" cellpadding="0" style="width: 2000px">
	<thead>
		<tr>
			@php
				$columns = [
					'Mã đăng ký',
					'Tên đề tài',
					'Lĩnh vực báo cáo',
					'Ngôn ngữ báo cáo',
					'Hạn nộp báo cáo tóm tắt',
					'Hạn nộp báo cáo toàn văn',
					'File báo cáo tóm tắt',
					'File báo cáo toàn văn',
					'Đăng ký đăng bài',
					'Chức danh',
					'Họ và tên',
					'Đơn vị công tác',
					'Chức vụ',
					'Địa chỉ liênh hệ',
					'Thư điện tử',
					'Điện thoại',
					'CMND/CCCD/HỘ CHIẾU',
					'Giới tính',
					'Ngày sinh',
					'Tháng sinh',
					'Năm sinh',
					'ĐĂNG KÝ THAM DỰ TẬP HUẤN TIỀN HỘI NGHỊ',
					'ĐĂNG KÝ THAM DỰ TIỆC CHIÊU ĐÃI HỘI NGHỊ',
					'Chuyên khoa',
					'Sô năm kinh nghiệm',
					'Các khóa đăng ký',
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
					<td>{{ $registration->topic }}</td>
					<td>{{ $registration->session }}</td>
					<td>{{ $registration->report_lang }}</td>
					<td>{{ $registration->report_deadline_summary }}</td>
					<td>{{ $registration->report_deadline_full }}</td>
					<td>
						@if($registration->report_file_summary)
							<a href="{{ get_image_url($registration->report_file_summary) }}">Download</a>
						@endif
					</td>
					<td>
						@if($registration->report_file_full)
							<a href="{{ get_image_url($registration->report_file_full) }}">Download</a>
						@endif
					</td>
					<td>{{ $registration->journal_vn }}</td>
					<td>{{ $registration->title }}</td>
					<td>{{ $registration->fullname }}</td>
					<td>{{ $registration->work }}</td>
					<td>{{ $registration->organization }}</td>
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
					<td>{{ $registration->register_reception }}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>