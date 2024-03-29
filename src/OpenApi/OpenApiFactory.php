<?php


namespace App\OpenApi;


use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(private OpenApiFactoryInterface $decorated){}

    /**
     * @param array<string> $context
     * @return OpenApi
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $this->hidePaths($openApi);

        $this->setAuthSecurityScheme($openApi);

        $this->setLoginPath($openApi);

        $this->addSchema($openApi, 'ResetPassword', new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'password' => [
                    'type' => 'string',
                    'example' => 'admin'
                ]
            ]
        ]));

        return $openApi;
    }

    private function hidePaths(OpenApi $openApi): void
    {
        /** @var PathItem $path */
        foreach ($openApi->getPaths()->getPaths() as $key => $path){
            if (!is_null($path->getGet()) && $path->getGet()->getSummary() === 'hidden'){
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }
    }

    private function setAuthSecurityScheme(OpenApi $openApi): void
    {
        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT'
        ]);
    }

    private function setLoginPath(OpenApi $openApi): void
    {
        $this->addSchema($openApi, 'Credentials', new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'admin@domain.net'
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'admin'
                ]
            ]
        ]));

        $this->addSchema($openApi, 'JWT', new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                ]
            ]
        ]));


        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogin',
                tags: ['Authentication'],
                responses: [
                '200' => [
                    'description' => 'Utilisateur connecté',
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/JWT'
                            ]
                        ]
                    ]
                ]
            ],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials'
                            ]
                        ]
                    ])
                )
            )
        );

        $openApi->getPaths()->addPath('/api/login', $pathItem);
    }

    private function addSchema(OpenApi $openApi, string $key,\ArrayObject $schema): void
    {
        $schemas = $openApi->getComponents()->getSchemas();
        $schemas[$key] = $schema;
    }
}