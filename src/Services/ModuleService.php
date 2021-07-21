<?php


namespace App\Services;


use _HumbugBoxda2413717501\Nette\Neon\Exception;
use App\Entity\Module;
use App\Entity\Sensor;
use App\Repository\ActionConditionRepository;
use App\Repository\ModuleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModuleService
{
    public function __construct(
        private ModuleRepository $moduleRepository,
        private ActionConditionRepository $actionConditionRepository
    ){}

    public function getActions(int $id): array
    {
        try {
            /** @var Module|null $module */
            $module = $this->moduleRepository->find($id);
            $family = $module->getFamilly();

            if (is_null($module)) {
//                return new JsonResponse(['message' => 'Le module n\'existe pas.'], 404);
            }

            $returnActions = [];

            /** @var Sensor $sensor */
            foreach ($module->getSensors() as $sensor) {
                $actionConditions = $this->actionConditionRepository->findBySensorTypeAndFamily($sensor->getType()->getId(), $family->getId());

                foreach ($actionConditions as $condition) {
                    $hasError = false;
                    switch ($condition->getOperator()) {
                        case '<':
                            if ($sensor->getLastValue() < $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                        case '>':
                            if ($sensor->getLastValue() > $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                        case '=':
                            if ($sensor->getLastValue() === $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                    }

                    if ($hasError) {
                        foreach ($condition->getActions() as $action){
                            $action->setSensorType($sensor->getType());
                            $returnActions[] = $action;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw new Exception($e);
        } finally {
            return $returnActions;
        }
    }
}