<?php

namespace App\Controller;


use App\Dto\DateRangeDTO;
use App\Dto\EnergyPriceDTO;
use App\Dto\EnergyPriceValuesDTO;
use App\Form\EnergyPricesType;
use App\Service\EnergyBillingRequestsApi;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnergyController extends AbstractController
{
    #[Route('/energy/index', name: 'app_energy_index')]
    public function index(
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $response = $energyBillingRequestsApi->getRequest($energyBillingRequestsApi::URL_SERVER . '/api/energy/list');

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', 'Error al obtener los precios de potencia: ' . $response->getContent());
            return $this->redirectToRoute('app_dashboard');
        }

        $energyPrices = json_decode($response->getContent());

        return $this->render('energy/index.html.twig', [
            'energyPrices' => $energyPrices,
        ]);
    }

    #[Route('/energy/delete/{id}', name: 'app_energy_delete', methods: ['DELETE'])]
    public function delete(
        int                      $id,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): JsonResponse
    {
        $response = $energyBillingRequestsApi->sendDeleteRequest($energyBillingRequestsApi::URL_SERVER . '/api/energy/delete/' . $id);

        if ($response->getStatusCode() !== 200) {
            return new JsonResponse(['status' => 'success', 'message' => 'Error al obtener los precios de potencia: ' . $response->getContent()], 400);
        }

        return new JsonResponse(['status' => 'success', 'message' => 'energy price deleted successfully'], 200);
    }


    #[Route('/energy/create', name: 'app_energy_create', methods: ['GET', 'POST'])]
    public function create(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi
    ): Response
    {
        $energyPriceDTO = new EnergyPriceDTO();
        $form = $this->createForm(EnergyPricesType::class, $energyPriceDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $energyPriceDTO = $form->getData();
            $energyPriceDTO->setId(0);
            $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/prices/energy', $energyPriceDTO);
            $decodedResponse = json_decode($response->getContent());
            $this->addFlash($decodedResponse->status, $decodedResponse->message);

            return $this->redirectToRoute('app_energy_index');
        }

        return $this->render('energy/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/energy/update/{id}', name: 'app_energy_update', methods: ['GET', 'POST'])]
    public function update(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $energyPriceDTO = new energyPriceDTO();

        $response = $energyBillingRequestsApi->getRequest($energyBillingRequestsApi::URL_SERVER . '/api/energy/' . $request->get('id'));

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', 'Error al obtener el precio de una potencia: ' . $response->getContent());
            return $this->redirectToRoute('app_dashboard');
        }

        $energyPriceDecoded = json_decode($response->getContent());

        $energyPriceValuesDTO = (new EnergyPriceValuesDTO())
            ->setP1($energyPriceDecoded->energyP1)
            ->setP2($energyPriceDecoded->energyP2)
            ->setP3($energyPriceDecoded->energyP3);
        $energyPriceDTO
            ->setId($energyPriceDecoded->id)
            ->setenergy($energyPriceValuesDTO)
            ->setStartDate(new DateTime($energyPriceDecoded->startDate))
            ->setEndDate(new DateTime($energyPriceDecoded->endDate))
            ->setUsername($energyPriceDecoded->username);


        $form = $this->createForm(energyPricesType::class, $energyPriceDTO);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $energyPriceDTO = $form->getData();
            $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/prices/energy', $energyPriceDTO);
            $decodedResponse = json_decode($response->getContent());
            $this->addFlash($decodedResponse->status, $decodedResponse->message);

            return $this->redirectToRoute('app_energy_index');
        }

        return $this->render('energy/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/energy/checkExistsDate', name: 'app_energy_checkdate', methods: ['GET', 'POST'])]
    public function checkExistsDate(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $dateRangeDTO = (new DateRangeDTO());

        $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/energy/checkExistsDate', $dateRangeDTO);


        if ($response->getStatusCode() !== 200) {
            return new JsonResponse([
                'data' => $response->getContent(),
                'status' => 'error',
            ], 400);

        }

        $data = json_decode($response->getContent(), true);

        return new JsonResponse([
            'data' => $data,
            'status' => 'success',
        ], 200);

    }

}
