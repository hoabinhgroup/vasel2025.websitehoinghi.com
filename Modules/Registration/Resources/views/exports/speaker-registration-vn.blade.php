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
					'Chuyên khoa',
					'Số năm kinh nghiệm',
					'Khóa tập huấn',
					'Tiệc chiêu đãi',
					'Các khóa đăng ký',
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
				'created_at' => $lastAudit->created_at->format('d/m/Y H:i'),
			];
		}
	}

	$registration->latest_updated_fields = $latestFields;
    $registration->latest_updated_at = $lastAudit && $lastAudit->created_at ? $lastAudit->created_at->format('d/m/Y H:i'): null;
				@endphp
				<tr>
					<td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
					<td>{{ $registration->latest_updated_at }}</td>
					<td>{{ $registration->guest_code }}</td>
					<td>{!! showChangedValue($registration, 'topic') !!}</td>
					<td>{!! showChangedValue($registration, 'session') !!}</td>
					<td>{!! showChangedValue($registration, 'report_lang') !!}</td>
					<td>
						{!! showChangedValue($registration, 'report_file_summary', true) !!}
					</td>
					<td>
						{!! showChangedValue($registration, 'report_file_full', true) !!}
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
					<td>{!! showChangedValue($registration, 'course') !!}</td>
					<td>{!! showChangedValue($registration, 'experience') !!}</td>
					<td>{!! showChangedValue($registration, 'training') !!}</td>
					<td>{!! showChangedValue($registration, 'galadinner') !!}</td>
					<td>{!! showChangedValue($registration, 'course_name') !!}</td>
					<td>{!! showChangedValue($registration, 'register_reception') !!}</td>
					<td>{!! showChangedValue($registration, 'form_invitation') !!}</td>
					<td>{!! showChangedValue($registration, 'form_certificate') !!}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>