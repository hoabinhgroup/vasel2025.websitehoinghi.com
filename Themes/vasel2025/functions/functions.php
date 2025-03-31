<?php

use Carbon\Carbon;


view()->composer([\Theme::current() . '::speaker-registration-vn-form', \Theme::current() . '::speaker-registration-form'], function ($view) {
    \Assets::addCss(
        [
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            themes('css/registration.css?v=' . time())
        ]
    );
    \Assets::addJs(
        [
            asset('vendor/jsvalidation/js/jsvalidation.js'),
            'https://cdn.jsdelivr.net/npm/flatpickr',
            themes('js/speaker-registration.js?v=' . time())
        ]
    );
});


view()->composer([\Theme::current() . '::invitee-registration-vn-form', \Theme::current() . '::invitee-registration-form'], function ($view) {
    \Assets::addCss(
        [
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            themes('css/registration.css?v=' . time())
        ]
    );
    \Assets::addJs(
        [
            asset('vendor/jsvalidation/js/jsvalidation.js'),
            'https://cdn.jsdelivr.net/npm/flatpickr',
            themes('js/speaker-registration.js?v=' . time())
        ]
    );
});



if (!function_exists("validUntil")) {
    function validUntil()
    {
        return Carbon::create(2025, 03, 25);
    }
}

if (!function_exists("checkExpiredFee")) {
    function checkExpiredFee()
    {

        $expired = false;
        $now = Carbon::now();
        if ($now->greaterThan(validUntil())) {
            $expired = true;
        }
        return $expired;
    }
}

if (!function_exists("conferenceFees")) {
    function conferenceFees()
    {
        return [
            'yes' => [
                1 => [
                    'id' => 1,
                    'name' => 'Physician (APSCVIR member)',
                    'galadinner' => true,
                    'amount' => checkExpiredFee() ? 550 : 450,
                    'amount_vn' => checkExpiredFee() ? 5000000 : 4000000,
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Physician (non member)',
                    'galadinner' => true,
                    'amount' => checkExpiredFee() ? 650 : 550,
                    'amount_vn' => checkExpiredFee() ? 6000000 : 5000000,
                ],
                3 => [
                    'id' => 3,
                    'name' => 'Allied health (Radiographer, Nurses, Physicist. Scientist, Exhibitors)',
                    'galadinner' => true,
                    'amount' => checkExpiredFee() ? 350 : 250,
                    'amount_vn' => checkExpiredFee() ? 3000000 : 2000000,
                ],
                4 => [
                    'id' => 4,
                    'name' => 'Young IR trainee*<35 years old (Medical Student, Resident, Fellow)',
                    'galadinner' => true,
                    'amount' => checkExpiredFee() ? 250 : 150,
                    'amount_vn' => checkExpiredFee() ? 2000000 : 1000000,
                ],
            ],
            'no' => [
                1 => [
                    'id' => 5,
                    'name' => 'Physician (APSCVIR member)',
                    'galadinner' => false,
                    'amount' => checkExpiredFee() ? 450 : 350,
                    'amount_vn' => checkExpiredFee() ? 4000000 : 3000000,
                ],
                2 => [
                    'id' => 6,
                    'name' => 'Physician (non member)',
                    'galadinner' => false,
                    'amount' => checkExpiredFee() ? 550 : 450,
                    'amount_vn' => checkExpiredFee() ? 5000000 : 4000000,
                ],
                3 => [
                    'id' => 7,
                    'name' => 'Allied health (Radiographer, Nurses, Physicist. Scientist, Exhibitors)',
                    'galadinner' => false,
                    'amount' => checkExpiredFee() ? 250 : 150,
                    'amount_vn' => checkExpiredFee() ? 2000000 : 1000000,
                ],
                4 => [
                    'id' => 8,
                    'name' => 'Young IR trainee*<35 years old (Medical Student, Resident, Fellow)',
                    'galadinner' => false,
                    'amount' => 0,
                    'amount_vn' => 0,
                ],
            ],
        ];
    }
}

if (!function_exists("conferenceFeesById")) {
    function conferenceFeesById()
    {
        $idMap = [];
        $registration = conferenceFees();
        foreach ($registration as $key => $group) {
            foreach ($group as $order => $registration) {
                $idMap[$registration['id']] = $registration;
            }
        }

        return $idMap;
    }
}


function sendEmail($to, $subject, $template)
{

    ini_set('SMTP', 'localhost');

    ini_set('smtp_port', '1025');

    // Dữ liệu cho template
    $data = [
        'name' => 'Tuấn Louis'
    ];

    // Render nội dung từ Blade template

    // Gửi email sử dụng mail() thông thường
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers (optional)
    $headers .= 'From: webmaster@example.com' . "\r\n";

    // Sử dụng hàm mail() để gửi email
    mail($to, $subject, $template, $headers);

    return 'Email sent!';
}

if (!function_exists("report_sessions")) {
    function report_sessions()
    {
        return [
            "GI Surgery",
            "Urology",
            "NeuroSurgery",
            "Orthopedic and Spinal Surgery",
            "Cardiovascular and Thoracic Surgery",
            "Maxillofacial and Plastic Surgery",
            "Transplantation",
            "Pediatric Surgery",
            "Imaging Intervention",
            "Endoscopy",
            "Nursing"
        ];
    }
}

if (!function_exists("report_sessions_vn")) {
    function report_sessions_vn()
    {
        return [
            0 => "Tiêu hóa",
            1 => "Tiết niệu",
            2 => "Thần kinh - Sọ não",
            3 => "Chấn thương - Cột sống",
            4 => "Tim mạch - Lồng ngực",
            5 => "Tạo hình - Thẩm mỹ",
            6 => "Ghép tạng",
            7 => "Nhi",
            8 => "Điện quang can thiệp",
            9 => "Nội soi và nội soi can thiệp",
            10 => "Điều dưỡng"
        ];
    }
}

if (!function_exists("array_course")) {
    function array_course()
    {
        return ['TIÊU HÓA', 'TIẾT NIỆU', 'CHẤN THƯƠNG - CHỈNH HÌNH'];
    }
}

if (!function_exists("courses")) {
    function courses()
    {
        return [
            'Chuyên đề Tiêu hóa: Phẫu thuật điều trị thoát vị thành bụng',
            'Chuyên đề Tiết niệu: Bóc nhân phì đại tuyến tiền liệt nội soi qua đường niệu đạo',
            'Chuyên đề Chấn thương: Phẫu thuật nội soi khớp vai điều trị rách chóp xoay'
        ];
    }
}


if (!function_exists("abstract_categories")) {
    function abstract_categories()
    {
        return [
            1 => "Faculty",
            2 => "Oral presentation",
            3 => "Poster presentation"
        ];
    }
}


if (!function_exists("abstract_topic")) {
    function abstract_topic()
    {
        return [
            1 => "Aortic/Iliac artery",
            2 => "AVF",
            3 => "Portal Hypertention",
            4 => "Peripheral Intervention (SFA/Iliac/BTK)",
            5 => "Visceral embolization",
            6 => "PAD",
            7 => "HCC",
            8 => "Pain Management",
            9 => "Ablations",
            10 => "MRI/CT guided intervention",
            11 => "Lung tumor",
            12 => "Stroke",
            13 => "DAVFs",
            14 => "Traumatic/Carotid",
            15 => "Aneurysm",
            16 => "Brain AVMs",
            17 => "Vascular Malformations",
            18 => "Venous interventions",
            19 => "Pediatric Intervention",
            20 => "Biliary intervention",
            21 => "Lymphatic Intervention",
            22 => "Technician/nurse session",
            23 => "Pelvic intervention",
            24 => "Non vascular intervention",
            25 => "Pelvic embolization (women)",
            26 => "Innovations",
            27 => "BTK",
        ];
    }
}



if (!function_exists("allCountries")) {
    function allCountries()
    {
        return array(
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "BQ" => "British Antarctic Territory",
            "IO" => "British Indian Ocean Territory",
            "VG" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CT" => "Canton and Enderbury Islands",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos [Keeling] Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo - Brazzaville",
            "CD" => "Congo - Kinshasa",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "CI" => "Côte d’Ivoire",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "NQ" => "Dronning Maud Land",
            "DD" => "East Germany",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "FQ" => "French Southern and Antarctic Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "HN" => "Honduras",
            "HK" => "Hong Kong SAR China",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JT" => "Johnston Island",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau SAR China",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "FX" => "Metropolitan France",
            "MX" => "Mexico",
            "FM" => "Micronesia",
            "MI" => "Midway Islands",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar [Burma]",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NT" => "Neutral Zone",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "KP" => "North Korea",
            "VD" => "North Vietnam",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PC" => "Pacific Islands Trust Territory",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territories",
            "PA" => "Panama",
            "PZ" => "Panama Canal Zone",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "YD" => "People's Democratic Republic of Yemen",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn Islands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RO" => "Romania",
            "RU" => "Russia",
            "RW" => "Rwanda",
            "RE" => "Réunion",
            "BL" => "Saint Barthélemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "KR" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syria",
            "ST" => "São Tomé and Príncipe",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UM" => "U.S. Minor Outlying Islands",
            "PU" => "U.S. Miscellaneous Pacific Islands",
            "VI" => "U.S. Virgin Islands",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "SU" => "Union of Soviet Socialist Republics",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "ZZ" => "Unknown or Invalid Region",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VA" => "Vatican City",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "WK" => "Wake Island",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
            "AX" => "Åland Islands",
        );
    }
}


if (!function_exists("sessions_day_select")) {
    function sessions_day_select()
    {
        return [
            [
                'value' => '2025-04-25',
                'label' => '25 April 2025'
            ],
            [
                'value' => '2025-04-26',
                'label' => '26 April 2025'
            ],
            [
                'value' => '2025-04-27',
                'label' => '27 April 2025'
            ]
        ];
    }
}


if (!function_exists("sessions_room_select")) {
    function sessions_room_select()
    {
        return [
            [
                'value' => 'Ballroom 3',
                'label' => 'Ballroom 3'
            ],
            [
                'value' => 'Ballroom 1A',
                'label' => 'Ballroom 1A'
            ],
            [
                'value' => 'Ballroom 1B',
                'label' => 'Ballroom 1B'
            ],
            [
                'value' => 'Hoi An Room',
                'label' => 'Hoi An Room'
            ],
            [
                'value' => 'My Son Room',
                'label' => 'My Son Room'
            ],
            [
                'value' => 'Phong Nha Room',
                'label' => 'Phong Nha Room'
            ],
            [
                'value' => 'Hue Room',
                'label' => 'Hue Room'
            ]
        ];
    }
}
