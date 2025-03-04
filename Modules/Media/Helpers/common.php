<?php

if (!function_exists('is_image')) {
    /**
     * Is the mime type an image
     *
     * @param string $mimeType
     * @return bool
     */
    function is_image($mimeType)
    {
        return LouisMedia::isImage($mimeType);
    }
}

if (!function_exists('get_image_url')) {
    /**
     * @param string $url
     * @param string $size
     * @param bool $relativePath
     * @param null $default
     * @return string
     */
    function get_image_url($url, $size = null, $relativePath = false, $default = null)
    {
        return LouisMedia::getImageUrl($url, $size, $relativePath, $default);
    }
}

if (!function_exists('get_object_image')) {
    /**
     * @param string $image
     * @param null $size
     * @param bool $relativePath
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function get_object_image($image, $size = null, $relativePath = false)
    {
        return LouisMedia::getObjectImage($image, $size, $relativePath);
    }
}

if (!function_exists('louis_media_handle_upload')) {
    /**
     * @param \Illuminate\Http\UploadedFile $fileUpload
     * @param int $folderId
     * @param string $path
     * @return array|\Illuminate\Http\JsonResponse
     */
    function louis_media_handle_upload($fileUpload, $folderId = 0, $path = '')
    {
        return LouisMedia::handleUpload($fileUpload, $folderId, $path);
    }
}

