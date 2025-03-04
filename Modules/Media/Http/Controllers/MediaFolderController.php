<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\Media\Http\Requests\MediaFolderRequest;
use Modules\Media\Repositories\MediaFileInterface;
use Modules\Media\Repositories\MediaFolderInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use LouisMedia;


class MediaFolderController extends Controller
{
    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * FolderController constructor.
     * @param MediaFolderInterface $folderRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(MediaFolderInterface $folderRepository, MediaFileInterface $fileRepository)
    {
        $this->folderRepository = $folderRepository;
        $this->fileRepository = $fileRepository;
    }
    
    /**
     * @param MediaFolderRequest $request
     * @return JsonResponse
     */
    public function store(MediaFolderRequest $request)
    {
        $name = $request->input('name');

        try {
            $parentId = $request->input('parent_id');

           // $folder = app()->make($this->folderRepository->getModel());
       
            $folder = [
                'user_id' => Auth::user()->getKey(),
                'name' => $this->folderRepository->createName($name, $parentId),
                'slug' => $this->folderRepository->createSlug($name, $parentId),
                'parent_id' => $parentId
            ];
            // $folder->user_id = Auth::user()->getKey();
            // $folder->name = $this->folderRepository->createName($name, $parentId);
            // $folder->slug = $this->folderRepository->createSlug($name, $parentId);
            // $folder->parent_id = $parentId;
            $this->folderRepository->createOrUpdate($folder);
            return LouisMedia::responseSuccess([], trans('media::media.folder_created'));
        } catch (Exception $exception) {
            return LouisMedia::responseError($exception->getMessage());
        }
    }
}
