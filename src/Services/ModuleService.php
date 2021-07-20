<?php


namespace App\Services;


use _HumbugBoxda2413717501\Nette\Utils\Json;
use App\Entity\Module;
use App\Entity\Sensor;
use App\Repository\ModuleRepository;
use App\Repository\SpecRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModuleService
{
    public function __construct(private ModuleRepository $moduleRepository, private SpecRepository $specRepository){}

    public function getInformations(int $id): JsonResponse
    {
        try {
            /** @var Module|null $module */
            $module = $this->moduleRepository->find($id);
            $family = $module->getFamilly();

            if(is_null($module)){
                return new JsonResponse(['message' => 'Le module n\'existe pas.'], 404);
            }

            /** @var Sensor $sensor */
            foreach ($module->getSensors() as $sensor) {
                $spec = $this->specRepository->findOneBySensorTypeAndFamily($sensor->getType()->getId(), $family->getId());

                dd($spec);

                //TODO: récupérer les valeurs
                $fake_value = 12;

                //TODO: Récupérer les fiches au besoin
                if ($fake_value < $spec->getMin()) {
                    // Add the sheet
                }

                if ($fake_value > $spec->getMax()) {
                    // Add the sheet
                }
            }
        } catch (\Exception $e){
            dd($e);
            return new JsonResponse(['error' => $e], 500);
        }


        return new JsonResponse($module);
    }
}