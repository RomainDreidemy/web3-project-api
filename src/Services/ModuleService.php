<?php


namespace App\Services;

use App\Entity\Api\ModuleApi;
use App\Entity\Module;
use App\Entity\SensorData;
use App\Entity\User;
use App\Repository\ActionConditionRepository;
use App\Repository\ModuleRepository;
use App\Repository\SensorRepository;
use App\Repository\SpecRepository;

class ModuleService
{
    public function __construct(
        private ModuleRepository $moduleRepository,
        private SensorRepository $sensorRepository,
        private ActionConditionRepository $actionConditionRepository,
        private SpecRepository $specRepository,
        private InfluxService $influxService,
    ){}

    public function getActions(int $id): array
    {

        try {
            /** @var Module|null $module */
            $module = $this->moduleRepository->find($id);
            $family = $module->getFamilly();


            if (is_null($module)) {
//                return new JsonResponse(['message' => 'Le module n\'existe pas.'], 404);
                dd('pas de module');
            }

            $datas = $this->influxService->getLastMeasurementsByNodeId($module->getInfluxId());

            $returnActions = [];

            foreach ($datas as $data){
                $actionConditions = $this->actionConditionRepository->findBySensorTypeAndFamily($data->getSensorType()->getId(), $family->getId());
                $sensor = $this->sensorRepository->findOneBy(['module' => $module, 'type' => $data->getSensorType()]);
                $spec = $this->specRepository->findOneBy(['family' => $family, 'sensorType' => $data->getSensorType()]);

                $sensorData = (new SensorData())
                    ->setSensorType($sensor->getType())
                    ->setModule($module)
                    ->setMin($spec->getMin())
                    ->setMax($spec->getMax())
                    ->setCurrentValue($data->getValue())
                    ->setStatus()
                ;

                foreach ($actionConditions as $condition) {

                    $hasError = false;
                    switch ($condition->getOperator()) {
                        case '<':
                            if ($data->getValue() < $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                        case '>':
                            if ($data->getValue() > $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                        case '=':
                            if ($data->getValue() === $condition->getValue()) {
                                $hasError = true;
                            }
                            break;
                    }

                    if ($hasError) {
                        foreach ($condition->getActions() as $action){
                            $sensorData
                                ->addAction($action)
                            ;
                        }
                    }

                }
                $returnActions[] = $sensorData;
            }

            return $returnActions;
        } catch (\Exception $e) {
            throw new \Exception($e);
        }


    }

    public function getModule(int $id): ModuleApi
    {
        $module = $this->moduleRepository->find($id);

        if(!is_null($module)){
            $actions = $this->getActions($id);

            $moduleApi = (new ModuleApi())
                ->setModule($module)
            ;

            foreach ($actions as $action){
                $moduleApi
                    ->addSensorData($action)
                ;
            }
        }

        return $moduleApi;
    }

    public function getModules(User $user): array
    {
        $modules = $this->moduleRepository->findBy(['user' => $user]);

        $array = [];

        foreach ($modules as $module){
            $array[] = $this->getModule($module->getId());
        }

        return $array;
    }
}