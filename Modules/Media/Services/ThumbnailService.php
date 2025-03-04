<?php

namespace Modules\Media\Services;

use Exception;
use Intervention\Image\ImageManager;
use Modules\Media\Services\UploadsManager;
use Log;
use Storage;

class ThumbnailService
{

    /**
     * @var ImageManager
     */
    protected $imageManager;
    
    
    protected $uploadsManager;

    /**
     * @var string
     */
    protected $imagePath;

    /**
     * @var float
     */
    protected $thumbRate;

    /**
     * @var int
     */
    protected $thumbWidth;

    /**
     * @var int
     */
    protected $thumbHeight;

    /**
     * @var string
     */
    protected $destinationPath;

    /**
     * @var string
     */
    protected $xCoordinate;

    /**
     * @var string
     */
    protected $yCoordinate;

    /**
     * @var string
     */
    protected $fitPosition;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * ThumbnailService constructor.
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->thumbRate = 0.75;
        $this->xCoordinate = null;
        $this->yCoordinate = null;
        $this->fitPosition = 'center';

        $driver = 'gd';
        if (extension_loaded('imagick')) {
            $driver = 'imagick';
        }

        $this->imageManager = $imageManager->configure(['driver' => $driver]);
    }

    /**
     * @param string $imagePath
     * @return ThumbnailService
     */
    public function setImage($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->imagePath;
    }

    /**
     * @param double $rate
     * @return ThumbnailService
     */
    public function setRate($rate)
    {
        $this->thumbRate = $rate;

        return $this;
    }

    /**
     * @return double
     */
    public function getRate()
    {
        return $this->thumbRate;
    }

    /**
     * @param int $width
     * @param int $height
     * @return ThumbnailService
     */
    public function setSize($width, $height = null)
    {
        $this->thumbWidth = $width;
        $this->thumbHeight = $height;

        if (empty($height)) {
            $this->thumbHeight = $this->thumbWidth * $this->thumbRate;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getSize()
    {
        return [$this->thumbWidth, $this->thumbHeight];
    }

    /**
     * @param string $destinationPath
     * @return ThumbnailService
     */
    public function setDestinationPath($destinationPath)
    {
        $this->destinationPath = $destinationPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationPath()
    {
        return $this->destinationPath;
    }

    /**
     * @param integer $xCoord
     * @param integer $yCoord
     * @return ThumbnailService
     */
    public function setCoordinates($xCoordination, $yCoordination)
    {
        $this->xCoordinate = $xCoordination;
        $this->yCoordinate = $yCoordination;

        return $this;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        return [$this->xCoordinate, $this->yCoordinate];
    }

    /**
     * @param string $position
     * @return ThumbnailService
     */
    public function setFitPosition($position)
    {
        $this->fitPosition = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getFitPosition()
    {
        return $this->fitPosition;
    }

    /**
     * @param string $fileName
     * @return ThumbnailService
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $type
     * @return bool|string
     */
    public function save($type = 'fit')
    {
        $fileName = pathinfo($this->imagePath, PATHINFO_BASENAME);

        if ($this->fileName) {
            $fileName = $this->fileName;
        }
        
      //  Log::error('$this->destinationPath ' . $this->destinationPath);

        $destinationPath = sprintf('%s/%s', trim($this->destinationPath, '/'), $fileName);
        
       // Log::error('$destinationPath ' . $destinationPath);

        $thumbImage = $this->imageManager->make($this->imagePath);

        switch ($type) {
            case 'resize':
                $thumbImage->resize($this->thumbWidth, $this->thumbHeight);
                break;
            case 'crop':
                $thumbImage->crop($this->thumbWidth, $this->thumbHeight, $this->xCoordinate, $this->yCoordinate);
                break;
            case 'fit':
                $thumbImage->fit($this->thumbWidth, $this->thumbHeight, null, $this->fitPosition);
        }
       // Log::error('Storage::disk(do_spaces) '. Storage::disk('do_spaces')->path(str_replace('./','',$destinationPath)));
        try {
            $thumbnailData = $thumbImage->encode();
            Storage::disk(setting('media_driver', 'public'))->put($destinationPath, $thumbnailData);
           // $thumbImage->save(Storage::disk('do_spaces')->path(str_replace('./','',$destinationPath)));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }

        return $destinationPath;
    }
}
