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
    \Log::info('Audit showChangedValue', [
        'Audit showChangedValue' => $registration->latest_updated_fields,
    ]);

    if (in_array($field, ['form_invitation', 'form_certificate'])) {
        return '<small style="color:#e67e22;">' . getTypeForm($registration->$field) . '</small>';
    }

    if (!empty($registration->latest_updated_fields[$field])) {
        $old = $registration->latest_updated_fields[$field]['old'];

        $new = $registration->latest_updated_fields[$field]['new'];
        $created_at = $registration->latest_updated_fields[$field]['created_at'];

        if ($old !== $new) {
            if ($isFile) {
                $oldFile = $old ? showDownloadLink($registration, $field, basename($old)) : 'Không có';
                $newFile = $new ? showDownloadLink($registration, $field, basename($new)) : 'Không có';

                return '<small style="color:#e67e22;">' . $newFile . '</small> (Update ' . $created_at . ')';
            }

            if (in_array($field, ['form_invitation', 'form_certificate'])) {
                return '<small style="color:#e67e22;">' . getTypeForm($new) . '</small> (Update ' . $created_at . ')';
            }

            return '<small style="color:#e74c3c;">' . e($new) . '</small> (Update ' . $created_at . ')';
        } else {
            // return e($new) . ' (Update ' . $created_at . ')';
            return e($new);
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


function getLastAudit($registration, $tag = null)
{
    $query = $registration->audits()
        ->where('event', 'updated');

    $query->where('tags', $tag);

    return $query->latest('created_at')->first();
}

function getDownloadLink($registration, $tag, $label)
{
    $lastAudit = getLastAudit($registration, $tag);
    $newValues = $lastAudit->new_values[$tag] ?? null;
    $createdAt = $lastAudit->created_at ?? null;

    if ($newValues || $createdAt) {
        return showDownloadLink($registration, $tag, $label . ' (Update ' . $createdAt->format('d/m/Y H:i') . ')');
    }

    return null;
}

function getLatestFields($lastAudit)
{

    if (!$lastAudit)
        return [];

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
    return $latestFields;
}

function getTypeForm($type)
{
    if ($type == 'soft') {
        return 'Bản mềm';
    } else {
        return 'Bản cứng';
    }
}