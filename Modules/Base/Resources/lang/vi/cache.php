<?php
	return [
   	   'cache_management' => 'Quản lý bộ nhớ đệm',  
   	   'cache_commands' => 'Các lệnh xóa bộ nhớ đệm cơ bản',
   	   'commands' => [
   	   			'clear_cms_cache' => [
	   	   				'title' => 'Xóa tất cả bộ đệm hiện có của ứng dụng',
   	   					'description' => 'Xóa các bộ nhớ đệm của ứng dụng: cơ sở dữ liệu, nội dung tĩnh... Chạy lệnh này khi bạn thử cập nhật dữ liệu nhưng giao diện không thay đổi'],
   	   			'refresh_compiled_views' => [
	   	   			    'title' => 'Làm mới bộ đệm giao diện',
   	   					'description' => 'Làm mới bộ đệm giao diện giúp phần giao diện luôn mới nhất'],
   	   			'clear_config_cache' => [
	   	   			   	'title' => 'Xóa bộ nhớ đệm của phần cấu hình',
   	   					'description' => 'Bạn cần làm mới bộ đệm cấu hình khi bạn tạo ra sự thay đổi nào đó ở môi trường thành phẩm.'],
   	   			'clear_route_cache' => [
	   	   				'title' => 'Xóa bộ nhớ đệm đường dẫn',
   	   					'description' => 'Cần thực hiện thao tác này khi thấy không xuất hiện đường dẫn mới.'],
   	   			'clear_log' => [
	   	   				'title' => 'Xóa lịch sử lỗi',
   	   					'description' => 'Xóa lịch sử lỗi.'],
   	   			]
   	    	   
	];
