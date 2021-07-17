<?php


namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Module;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private Security $security){}

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        $entities = [Module::class];

        if (!in_array($resourceClass, $entities) || null === $user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        match ($resourceClass) {
            Module::class => $this->module($queryBuilder, $user, $rootAlias)
        };
    }

    private function module(QueryBuilder $queryBuilder, UserInterface $user,string $rootAlias): void
    {
        $queryBuilder
            ->innerJoin(sprintf('%s.user', $rootAlias), 'u')
            ->andWhere('u.id = :current_user')
            ->setParameter('current_user', $user->getId())
        ;
    }
}