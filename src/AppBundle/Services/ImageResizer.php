<?php

namespace AppBundle\Services;

use abeautifulsite\SimpleImage;

class ImageResizer{

    public function generateSmallerImage($image){

        $simpleImage = new SimpleImage(
            $image->getPathToOriginal().'/'.$image->getFilename()
        );

        $img = $simpleImage
            ->best_fit(600,600)
            ->save($image->getPathToMedium().'/'.$image->getFilename());

        $thumbnail = $simpleImage
            ->thumbnail(60)
            ->desaturate()
            ->save($image->getPathToThumbnail().'/'.$image->getFilename());

    }


}