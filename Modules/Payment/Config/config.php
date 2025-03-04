<?php

return [
    'name' => 'Payment',
	'info' => [
    	'domestic' => [ // Noi dia
        	'vpc_Merchant' => 'ONEPAY',
			'vpc_AccessCode' => 'D67342C2',
			'vpc_SecureHash' => 'A3EFDFABA8653DF2342E8DAC29B51AF0',
			'vpc_url' => 'https://mtf.onepay.vn/onecomm-pay/vpc.op',
		],
    	'international_test' => [ // Quoc te
       		'vpc_Merchant' => 'TESTONEPAY33',
	   		'vpc_AccessCode' => '6BEB2566',
	   		'vpc_SecureHash' => '6D0870CDE5F24F34F3915FB0045120D6',
            'vpc_url' => 'https://mtf.onepay.vn/paygate/vpcpay.op',
        ],
		'international' => [ // Quoc te
       		'vpc_Merchant' => 'HOABINHTOUR2',
	   		'vpc_AccessCode' => '7763F5C5',
	   		'vpc_SecureHash' => 'E89978A34FCD1E64B44DB6F063068771',
	   		'vpc_url' => 'https://onepay.vn/vpcpay/vpcpay.op',
	   	],
	    'international_vnd' => [ // Quoc te
			  'vpc_Merchant' => 'HBTOUR2',
			  'vpc_AccessCode' => '37A07C2E',
			  'vpc_SecureHash' => '2A15C553DC9DBC44284A2020DD489C42',
			  'vpc_url' => 'https://onepay.vn/vpcpay/vpcpay.op',
		  ]
	]
    
];
