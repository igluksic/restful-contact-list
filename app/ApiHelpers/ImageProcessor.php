<?php
namespace App\ApiHelpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Constraint;

class ImageProcessor
{

    const DEFAULT_IMAGE_SIZE=200;
    const IMAGE_QUALITY = 70;

    protected $imageSize;
    protected $image;

    protected $imageError;

    public function __construct($image, $imageSize = 0)
    {
        $this->imageError = 0;

        if ($imageSize == 0) {
            $this->imageSize = ImageProcessor::DEFAULT_IMAGE_SIZE;
        }

        if (!is_file($image->getRealPath())) {
            $this->imageError = 1;
        } else {
            $this->image = (new ImageManager())->make($image);
        }
    }

    /**
     * Image processor, base64 output
     *
     * @return string
     */

    public function getImageBase64()
    {
        if ($this->imageError) {
            //TODO: some kind of error processing, this usually happens because of max file upload size
            return "";
        }

        $this->image->resize(null, $this->imageSize, function (Constraint $constraint){
            $constraint->aspectRatio();
        });
        $imageBase64 = base64_encode($this->image->stream(null, ImageProcessor::IMAGE_QUALITY)->__toString());
        $this->image->destroy();

        return $imageBase64;
    }

}