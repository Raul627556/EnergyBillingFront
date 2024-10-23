<?php

namespace App\Controller;

use App\Dto\InvoiceDTO;
use App\Form\InvoiceType;
use App\Service\EnergyBillingRequestsApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BillingController extends AbstractController
{

    #[Route('/billing/index', name: 'app_billing_index')]
    public function index(
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): Response
    {
        $response = $energyBillingRequestsApi->getRequest($energyBillingRequestsApi::URL_SERVER . '/api/billing/list');

        if ($response->getStatusCode() !== 200) {
            $this->addFlash('error', 'Error al obtener las facturas: ' . $response->getContent());
            return $this->redirectToRoute('app_dashboard');
        }

        $invoices = json_decode($response->getContent());

        return $this->render('billing/index.html.twig', [
            'invoices' => $invoices,
        ]);
    }


    #[Route('/billing/delete/{id}', name: 'app_billing_delete', methods: ['DELETE'])]
    public function delete(
        int                      $id,
        EnergyBillingRequestsApi $energyBillingRequestsApi,
    ): JsonResponse
    {
        $response = $energyBillingRequestsApi->sendDeleteRequest($energyBillingRequestsApi::URL_SERVER . '/api/billing/delete/' . $id);

        if ($response->getStatusCode() !== 200) {
            return new JsonResponse(['status' => 'success', 'message' => 'Error al borra la factura' . $response->getContent()], 400);
        }

        return new JsonResponse(['status' => 'success', 'message' => 'Factura borrada existosamente'], 200);
    }


    #[Route('/billing/create', name: 'app_billing_create', methods: ['GET', 'POST'])]
    public function create(
        Request                  $request,
        EnergyBillingRequestsApi $energyBillingRequestsApi
    ): Response
    {
        $invoiceDTO = new InvoiceDTO();
        $form = $this->createForm(InvoiceType::class, $invoiceDTO);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $invoiceDTO = $form->getData();
            $invoiceDTO->setId(0);
            $response = $energyBillingRequestsApi->sendRequest($energyBillingRequestsApi::URL_SERVER . '/api/generatebill', $invoiceDTO);
            if ($response->getStatusCode() !== 200) {
                $this->addFlash('error', 'Error al generar factura: ' . $response->getContent());
            }
            $this->addFlash('success', 'Factura Generada');

            return $this->redirectToRoute('app_billing_index');
        }

        return $this->render('billing/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
