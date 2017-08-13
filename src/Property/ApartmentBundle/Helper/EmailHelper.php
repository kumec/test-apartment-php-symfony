<?php
namespace Property\ApartmentBundle\Helper;
use Property\ApartmentBundle\Entity\Apartment;

/**
 * Mail Helper
 *
 */
class EmailHelper
{

    /**
     * service container
     *
     * @var object
     */
    protected $service;

    /**
     * twig
     *
     * @var object
     */
    protected $twig;

    /**
     * init service
     *
     * @param object $service
     * @return $this
     */
    public function __construct($service, \Twig_Environment $twig) {
        $this->service = $service;
        $this->twig = $twig;

        return $this;
    }


    private function sendEmail(\Swift_Message $message)
    {
        return $this->service->get('mailer')->send($message);
    }

    public function addApartment(Apartment $apartment){
        $message = (new \Swift_Message('Added new appartment'))
            ->setFrom($this->service->getParameter('support_email'))
            ->setTo($apartment->getOwnerEmail())
            ->setBody(
                $this->twig->render(
                    '@emails/add-apartment.html.twig',
                    array('apartment' => $apartment)
                ),
                'text/html'
            );

        $this->sendEmail($message);
    }

}