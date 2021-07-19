<?php

namespace App\Services;
use Cloudinary\Cloudinary;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\FileBag;

class UploadService
{
    public function __construct()
    {
//        Cloudinary::config(array(
//            "cloud_name" => $_SERVER['CLOUDINARY_NAME'],
//            "api_key" => $_SERVER['CLOUDINARY_KEY'],
//            "api_secret" => $_SERVER['CLOUDINARY_SECRET'],
//            "secure" => true
//        ));
    }
//
//    /**
//     * The function allows to delete images according to whether they exist and their directory.
//     * @param $images
//     * @throws Exception
//     */
//    public
//    function imagesRemove($images): void
//    {
//        try {
//            foreach ($images as $image) {
//                Uploader::destroy($image['public_id']);
//            }
//        } catch (Exception $e) {
//            throw $e;
//        }
//    }
//
//    /**
//     * The function allows to delete an image.
//     * @param $publicId
//     * @throws Exception
//     */
//    public function remove(string $publicId): void
//    {
//        try {
//            Uploader::destroy($publicId);
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
//    }
//
//    /**
//     * The functions allows to upload the selected images to their selected directory.
//     * @param FileBag $files
//     * @param array $options
//     * @return array
//     * @throws Exception
//     */
//    public function imagesUpload(FileBag $files, array $options = array()): array
//    {
//        try {
//            $imagesUploaded = [];
//
//            if ($options['maximum'] < $total = count($files)) {
//                throw new Exception("The number of images given is greater than {$options['maximum']} (Given {$total})");
//            }
//
//            $options = ['folder' => $options['path'], 'backup' => true];
//
//            foreach ($files as $file) {
//                $currentUpload = $this->upload($file, $options);
//
//                array_push($imagesUploaded, [
//                    'asset_id' => $currentUpload['asset_id'],
//                    'secure_url' => $currentUpload['secure_url'],
//                    'public_id' => $currentUpload['public_id'],
//                    'format' => $currentUpload['format'],
//                ]);
//            }
//            return $imagesUploaded;
//        } catch (Exception $e) {
//            throw new Exception ($e);
//        }
//    }
//
//    /**
//     * The functions allows to upload a file.
//     * @param File $file
//     * @param array $options
//     * @return mixed|null
//     * @throws Exception
//     */
//    public function upload(File $file, array $options = array())
//    {
//        try {
//            if ($file->getClientMimeType() === 'video/mp4') {
//                $ref = Uploader::upload_large($file, $options);
//                $ref['format'] = 'mp4';
//            } else {
//                $ref = Uploader::upload($file, $options);
//            }
//            return $ref;
//        } catch (Exception $e) {
//            throw new Exception ($e);
//        }
//    }
}