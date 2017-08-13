<?php

namespace Property\ApartmentBundle\Controller;

use Property\ApartmentBundle\Helper\EmailHelper;
use Property\ApartmentBundle\Form\ApartmentType;
use Property\ApartmentBundle\Repository\ApartmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Property\ApartmentBundle\Entity\Apartment;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * Class ApiController
 * @package PropertyApartmentBundle\Controller
 *
 */
class ApiController extends FOSRestController
{
    const TOKEN_LENGHT = 32;

    /**
     * Generate secret token
     *
     * @return string
     */
    private function generateToken()
    {
        $str = random_bytes(self::TOKEN_LENGHT);
        $encoded = strtr(base64_encode($str), '+/', '-_');
        return substr($encoded, 0, self::TOKEN_LENGHT);
    }

    /**
     * Check rights by access token
     *
     * @param Apartment $apartment
     * @param Request $request
     * @return bool
     * @throws AccessDeniedException
     */
    private function checkAccess(Apartment $apartment,Request $request)
    {
        $recivedAccessToken = $request->get('token');
        if($recivedAccessToken == $apartment->getAccessToken()){
            return true;
        }

        throw new AccessDeniedException();
    }

    /**
     * Process insert or update
     *
     * @param Request $request
     * @param Apartment $apartment
     * @return \Symfony\Component\Form\Form|Response
     */
    private function processForm(Request $request, Apartment $apartment)
    {
        $isNew = $apartment->getId() ? false : true;
        $form = $this->createForm(ApartmentType::class, $apartment, ['method' => ($isNew? 'POST' : 'PUT')]);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            /**
             * @var $apartment Apartment
             */
            $apartment = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if($isNew){
                $statusCode = Response::HTTP_CREATED;
                $apartment->setAccessToken($this->generateToken());
                $em->persist($apartment);
            } else {
                $statusCode = Response::HTTP_NO_CONTENT;
            }

            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->headers->set('Location',
                $this->generateUrl(
                    'get', ['id' => $apartment->getId()],
                    true // absolute
                )
            );
            if($isNew){
                $this->get('property.apartment.helper.email')->addApartment($apartment);
            }

            return $response;
        } else {
            return $form;
        }

    }

    /**
     * Gets a collection of Apartments
     *
     * @return array
     *
     * @ApiDoc(
     *     output="Property\ApartmentBundle\Entity\Apartment",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @Rest\Get("/apartment")
     */
    public function viewAction()
    {
        $apartmentQuery = $this->getDoctrine()->getRepository(Apartment::class);
        $apartments = $apartmentQuery->findAll();

        return $apartments;
    }

    /**
     * Gets an individual Apartment
     *
     * @ApiDoc(
     *     output="Property\ApartmentBundle\Entity\Apartment",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     *
     * @Rest\Get("/apartment/{id}")
     */
    public function getAction($id)
    {
        $apartmentQuery = $this->getDoctrine()->getRepository(Apartment::class);
        $apartment = $apartmentQuery->find($id);

        if (!$apartment instanceof Apartment) {
            throw new NotFoundHttpException('Apartment not found');
        }

        return $apartment;
    }

    /**
     * Insert new Apartment
     *
     * @param Request $request
     * @return View|\Symfony\Component\Form\Form
     *
     * @ApiDoc(
     *     input="Property\ApartmentBundle\Type\ApartmentType",
     *     output="Property\ApartmentBundle\Entity\Apartment",
     *     statusCodes={
     *         201 = "Returned when a new Apartment has been successful created",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @Rest\Post("/apartment")
     */
    public function postAction(Request $request)
    {
        return $this->processForm($request, new Apartment());
    }



    /**
     * Update existing Apartment
     *
     * @ApiDoc(
     *     input="Property\ApartmentBundle\Type\ApartmentType",
     *     output="Property\ApartmentBundle\Entity\Apartment",
     *     statusCodes={
     *         204 = "Returned when an existing Apartment has been successful updated",
     *         400 = "Return when errors",
     *         403 = "Returned when access denied",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @param Request $request
     * @param int     $id
     * @return View|\Symfony\Component\Form\Form
     *
     *  @Rest\Put("/apartment/{id}")
     */
    public function putAction(Request $request, int $id)
    {
        /**
         * @var $apartment Apartment
         */
        $apartmentQuery = $this->getDoctrine()->getRepository(Apartment::class);
        $apartment = $apartmentQuery->find($id);
        if (!$apartment instanceof Apartment) {
            throw new NotFoundHttpException('Apartment not found');
        }

        $this->checkAccess($apartment, $request);

        return $this->processForm($request, $apartment);
    }

    /**
     * Delete existing Apartment
     *
     * @param int $id
     * @return View
     *
     * @ApiDoc(
     *     statusCodes={
     *         204 = "Returned when an existing Apartment has been successful deleted",
     *         403 = "Returned when access denied",
     *         404 = "Return when not found"
     *     }
     * )
     *
     * @Rest\Delete("/apartment/{id}")
     */
    public function deleteAction(Request $request, int $id)
    {
        /**
         * @var $apartment Apartment
         */
        $apartmentQuery = $this->getDoctrine()->getRepository(Apartment::class);
        $apartment = $apartmentQuery->find($id);
        if (!$apartment instanceof Apartment) {
            throw new NotFoundHttpException('Apartment not found');
        }

        $this->checkAccess($apartment, $request);

        $em = $this->getDoctrine()->getManager();
        $em->remove($apartment);
        $em->flush();

        return new View(null, Response::HTTP_NO_CONTENT);
    }

}
