<?php

namespace Modules\Media\Http\Controllers;

use Modules\Media\Chunks\Exceptions\UploadMissingFileException;
use Modules\Media\Chunks\Handler\DropZoneUploadHandler;
use Modules\Media\Chunks\Receiver\FileReceiver;
use Modules\Media\Repositories\MediaFileInterface;
use Modules\Media\Http\Requests\MediaFileRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use LouisMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @since 19/08/2015 07:50 AM
 */
class MediaFileController extends Controller
{
    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @param MediaFileInterface $fileRepository
     * @param MediaFolderInterface $folderRepository
     */
    public function __construct(MediaFileInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    // public function postUpload(Request $request)
    //    {
    //        if (! LouisMedia::isChunkUploadEnabled()) {
    //            $result = LouisMedia::handleUpload(Arr::first($request->file('file')), $request->input('folder_id', 0));
    //    
    //            return $this->handleUploadResponse($result);
    //        }
    //    
    //        try {
    //            // Create the file receiver
    //            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
    //            // Check if the upload is success, throw exception or return response you need
    //            if ($receiver->isUploaded() === false) {
    //                throw new UploadMissingFileException();
    //            }
    //            // Receive the file
    //            $save = $receiver->receive();
    //            // Check if the upload has finished (in chunk mode it will send smaller files)
    //            if ($save->isFinished()) {
    //                $result = LouisMedia::handleUpload($save->getFile(), $request->input('folder_id', 0));
    //    
    //                return $this->handleUploadResponse($result);
    //            }
    //            // We are in chunk mode, lets send the current progress
    //            $handler = $save->handler();
    //    
    //            return response()->json([
    //                'done' => $handler->getPercentageDone(),
    //                'status' => true,
    //            ]);
    //        } catch (Exception $exception) {
    //            return LouisMedia::responseError($exception->getMessage());
    //        }
    //    }
    
    public function postUpload(MediaFileRequest $request)
    {
        $result = LouisMedia::handleUpload(Arr::first($request->file('file')), $request->input('folder_id', 0));
    
        if ($result['error'] == false) {
            return LouisMedia::responseSuccess([
                'id'  => $result['data']->id,
                'src' => Storage::url($result['data']->url),
            ]);
        }
    
        return LouisMedia::responseError($result['message']);
    }
       
       // protected function handleUploadResponse(array $result): JsonResponse
       // {
       //     if (! $result['error']) {
       //         return LouisMedia::responseSuccess([
       //             'id' => $result['data']->id,
       //             'src' => LouisMedia::url($result['data']->url),
       //         ]);
       //     }
       // 
       //     return LouisMedia::responseError($result['message']);
       // }

    /**
     * @param Request $request
     * @return ResponseFactory|JsonResponse|Response
     * @throws FileNotFoundException
     */
    public function postUploadFromEditor(Request $request)
    {
        return LouisMedia::uploadFromEditor($request);
    }
}
