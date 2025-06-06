@php
	use Illuminate\Support\Str;
	use Modules\Registration\Entities\SpeakerRegistrationVn;
	// 	$latestChanges = [];
	//     $registration = SpeakerRegistrationVn::find(12);
	// foreach ($registration->audits()->where('event', 'updated')->latest()->get() as $audit) {
	//     foreach ($audit->new_values as $field => $newValue) {
	//         // Chỉ lưu nếu chưa có thời gian thay đổi của field này
	//         if (!isset($latestChanges[$field])) {
	//             $latestChanges[$field] = [
	//                 'changed_at' => $audit->created_at,
	//                 'new_value' => $newValue,
	//                 'old_value' => $audit->old_values[$field] ?? null,
	//             ];
	//         }
	//     }
	// }

	// echo '<pre>';
	// print_r($latestChanges);
	// echo '</pre>'; die();

	/*dd(app(SpeakerRegistrationVn::class)->find(33)->audits()
					->where('event', 'updated')
					->where('tags', '')

					->latest()
					->first());*/
@endphp
<table border="1" cellspacing="0" cellpadding="0" style="width: 2000px">
	<thead>
		<tr>
			@php
				$columns = [
					'Ngày đăng ký',
					'Ngày chỉnh sửa',
					'Mã đăng ký',
					'Tên đề tài',
					'Lĩnh vực báo cáo',
					'Ngôn ngữ báo cáo',
					'File báo cáo tóm tắt',
					'File báo cáo toàn văn',
					'Đăng ký đăng bài',
					'Chức danh',
					'Họ và tên',
					'Đơn vị công tác',
					'Chức vụ',
					'Địa chỉ liên hệ',
					'Thư điện tử',
					'Điện thoại',
					'CMND/CCCD/HỘ CHIẾU',
					'Giới tính',
					'Ngày sinh',
					'Tháng sinh',
					'Năm sinh',
					'Đăng ký tập huấn tiền hội nghị',
					'Chuyên khoa',
					'Số năm kinh nghiệm',
					'Khóa đăng ký',
					'Tiệc chiêu đãi',
					'Hình thưc nhận giấy mời',
					'Hình thức nhận chứng nhận',

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
					$report_file_full = getDownloadLink($registration, 'report_file_full', 'Download');
					$report_file_summary = getDownloadLink($registration, 'report_file_summary', 'Download');

					$registration->latest_updated_fields = getLatestFields($lastAudit);
					$registration->latest_updated_at = $lastAudit && $lastAudit->created_at
						? $lastAudit->created_at->format('d/m/Y H:i')
						: null;
				@endphp
				<tr>
					<td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
					<td>{{ $registration->latest_updated_at }}</td>
					<td>{{ $registration->guest_code }}</td>
					<td>{!! showChangedValue($registration, 'topic') !!}</td>
					<td>{!! showChangedValue($registration, 'session') !!}</td>
					<td>{!! showChangedValue($registration, 'report_lang') !!}</td>
					<td>
						{!!  $report_file_summary !!}
						<!-- {!! showChangedValue($registration, 'report_file_summary', true) !!} -->
					</td>
					<td>
						{!!  $report_file_full !!}
						<!-- {!! showChangedValue($registration, 'report_file_full', true) !!} -->
					</td>
					<td>{!! showChangedValue($registration, 'journal_vn') !!}</td>
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
					<td>{!! showChangedValue($registration, 'course') !!}</td>
					<td>{!! showChangedValue($registration, 'experience') !!}</td>
					<td>{!! showChangedValue($registration, 'course_name') !!}</td>
					<td>{!! showChangedValue($registration, 'galadinner') !!}</td>

					<td>{!! showChangedValue($registration, 'form_invitation') !!}</td>
					<td>{!! showChangedValue($registration, 'form_certificate') !!}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>