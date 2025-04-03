<?php

if (!defined('REGISTRATION_NAME')) {
    define('REGISTRATION_NAME', 'registration');
}

if (!defined('REGISTRATION_SCREEN')) {
    define('REGISTRATION_SCREEN', 'registration');
}

if (!defined('BANK_TRANSFER')) {
    define('BANK_TRANSFER', 'bank-transfer');
}

if (!defined('ONLINE_PAYMENT')) {
    define('ONLINE_PAYMENT', 'online-payment');
}



function showFieldWithUpdate($registration, $field)
{


    $value = $registration->$field;

    if (in_array($field, $registration->latest_updated_fields ?? [])) {
        $value .= '<br><small style="color:#e74c3c;">(Đã cập nhật: ' .
            $registration->latest_updated_at->format('d/m/Y H:i') .
            ')</small>';
    }

    return $value;
}


function showChangedValue($registration, $field, $isFile = false)
{
    if (!empty($registration->latest_updated_fields[$field])) {
        $old = $registration->latest_updated_fields[$field]['old'];
        $new = $registration->latest_updated_fields[$field]['new'];

        if ($old != $new) {
            if ($isFile) {
                $oldFile = $old ? showDownloadLink($registration, $field, basename($old)) : 'Không có';
                $newFile = $new ? showDownloadLink($registration, $field, basename($new)) : 'Không có';

                return '<br><small style="color:#e67e22;">(Đã cập nhật: ' . $oldFile . ' → ' . $newFile . ')</small>';
            }

            return  e($old) . '<br><small style="color:#e74c3c;">(Đã cập nhật: '
                . e($new) . ')</small>';
        } else {
            return e($old);
        }
    } else {
        return $isFile ? showDownloadLink($registration, $field, basename(e($registration->$field))) : e($registration->$field);
    }

    return '';
}

function showDownloadLink($registration, $field, $label)
{
    if ($registration->$field) {
        return '<a href="' . get_image_url($registration->$field) . '">' . $label . '</a>';
    }
}
