<?php

namespace App\Services;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

class UploadService
{
    public function __construct(private string $cloudName,
                                private string $cloudApiKey,
                                private string $cloudApiSecret)
    {
        $config = Configuration::instance();
        $config->cloud->cloudName = $cloudName;
        $config->cloud->apiKey = $cloudApiKey;
        $config->cloud->apiSecret = $cloudApiSecret;
        $config->url->secure = true;
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
    /**
     * The functions allows to upload a file.
     * @param File $file
     * @param array $options
     * @return ApiResponse
     * @throws Exception
     */
    public function upload(File $file, $options = []): ApiResponse
    {
        try {


            return (new UploadApi())->upload($file->getPathname(), $options);
        } catch (Exception $e) {
            throw new Exception ($e);
        }
    }
}