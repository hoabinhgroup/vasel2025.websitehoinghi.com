<?php

function onesignalSendMessage($data)
{
  if (!empty($data)) {
    $content = [
      "en" => $data->name,
    ];
    $hashes_array = [];
    array_push($hashes_array, [
      "id" => "like-button",
      "text" => "Like",
      "icon" => "http://i.imgur.com/N8SN8ZS.png",
      "url" => domain() . "/" . $data->slug . ".html",
    ]);
    array_push($hashes_array, [
      "id" => "like-button-2",
      "text" => "Like2",
      "icon" => "http://i.imgur.com/N8SN8ZS.png",
      "url" => domain() . "/" . $data->slug . ".html",
    ]);
    $fields = [
      "app_id" => "df77d758-9d83-49d8-99dc-4cb3976ca99b",
      "included_segments" => ["All"],
      "data" => [
        "foo" => "bar",
      ],
      "contents" => $content,
      "web_buttons" => $hashes_array,
    ];

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type: application/json; charset=utf-8",
      "Authorization: Basic Y2Y1YzE1OGEtY2NhZS00MDQyLWJkZGMtZGQ5Nzg3Mzg1ZWVm",
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }
}

function sendSubcribeNotification($data)
{
  return onesignalSendMessage($data);
}
