<?php

namespace App\Controller;

use App\Dto\PowerPriceDTO;
use App\Dto\PowerPriceValuesDTO;
use App\Form\PowerPricesType;
use App\Service\EnergyBillingRequestsApi;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PowerController extends AbstractController
{
    #[Route('/power/index', name: 'app_power_index')]
    public function index(
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $response = $energyBillingRequestsApi->getRequest($energyBillingRequestsApi::URL_SERVER . '/api/power/list');

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', 'Error al obtener los precios de potencia: ' . $response->getContent());
            return $this->redirectToRoute('app_dashboard');
        }

        $powerPrices = json_decode($response->getContent());

        return $this->render('power/index.html.twig', [
            'powerPrices' => $powerPrices,
        ]);
    }

    #[Route('/power/delete/{id}', name: 'app_power_delete', methods: ['DELETE'])]
    public function delete(
        int                      $id,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): JsonResponse
    {
        $response = $energyBillingRequestsApi->sendDeleteRequest($energyBillingRequestsApi::URL_SERVER . '/api/power/delete/' . $id);

        if ($response->getStatusCode() !== 200) {
            return new JsonResponse(['status' => 'success', 'message' => 'Error al obtener los precios de potencia: ' . $response->getContent()], 400);
        }

        return new JsonResponse(['status' => 'success', 'message' => 'Power price deleted successfully'], 200);
    }


    #[Route('/power/create', name: 'app_power_create', methods: ['GET', 'POST'])]
    public function create(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi
    ): Response
    {
        $powerPriceDTO = new PowerPriceDTO();
        $form = $this->createForm(PowerPricesType::class, $powerPriceDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $powerPriceDTO = $form->getData();
            $powerPriceDTO->setId(0);
            $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/prices/power', $powerPriceDTO);
            $decodedResponse = json_decode($response->getContent());
            $this->addFlash($decodedResponse->status, $decodedResponse->message);

            return $this->redirectToRoute('app_power_index');
        }

        return $this->render('power/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/power/update/{id}', name: 'app_power_update', methods: ['GET', 'POST'])]
    public function update(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $powerPriceDTO = new PowerPriceDTO();

        $response = $energyBillingRequestsApi->getRequest($energyBillingRequestsApi::URL_SERVER . '/api/power/' . $request->get('id'));

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', 'Error al obtener el precio de una potencia: ' . $response->getContent());
            return $this->redirectToRoute('app_dashboard');
        }

        $powerPriceDecoded = json_decode($response->getContent());

        $powerPriceValuesDTO = (new PowerPriceValuesDTO())
            ->setP1($powerPriceDecoded->powerP1)
            ->setP2($powerPriceDecoded->powerP2)
            ->setP3($powerPriceDecoded->powerP3);
        $powerPriceDTO
            ->setId($powerPriceDecoded->id)
            ->setPower($powerPriceValuesDTO)
            ->setStartDate(new DateTime($powerPriceDecoded->startDate))
            ->setEndDate(new DateTime($powerPriceDecoded->endDate))
            ->setUsername($powerPriceDecoded->username);


        $form = $this->createForm(PowerPricesType::class, $powerPriceDTO);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $powerPriceDTO = $form->getData();
            $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/prices/power', $powerPriceDTO);
            $decodedResponse = json_decode($response->getContent());
            $this->addFlash($decodedResponse->status, $decodedResponse->message);

            return $this->redirectToRoute('app_power_index');
        }

        return $this->render('power/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
