<?php

namespace App\Services;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\BaseApiClient;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

class UploadService
{
    public function __construct(private string $appEnv,
                                private string $cloudName,
                                private string $cloudApiKey,
                                private string $cloudApiSecret)
    {
        $config = Configuration::instance();
        $config->cloud->cloudName = $cloudName;
        $config->cloud->apiKey = $cloudApiKey;
        $config->cloud->apiSecret = $cloudApiSecret;
        $config->url->secure = true;
    }

    /**
     * The function allows to delete a file.
     * @param $publicId
     * @return ApiResponse
     * @throws Exception
     */
    public function remove(string $publicId): ApiResponse
    {
        try {
           return (new UploadApi())->destroy($publicId);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * The function allows to upload a file.
     * @param File $file
     * @param string[] $options
     * @return ApiResponse<array>
     * @throws Exception
     */
    public function upload(File $file, array $options): ApiResponse
    {
        try {
            return (new UploadApi())->upload($file->getPathname(), $this->overwriteOptions($options));
        } catch (Exception $e) {
            throw new Exception ($e);
        }
    }

    /**
     * The function overwrites options data.
     * @param string[] $options
     * @return string[]
     */
    private function overwriteOptions(array $options): array
    {
        $options['folder'] = "{$this->appEnv}/{$options['folder']}";

        return UploadApi::buildUploadParams($options);
    }
}