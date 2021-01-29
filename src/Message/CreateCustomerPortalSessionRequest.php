<?php

namespace Omnipay\Stripe\Message;

/**
 * Stripe Create Customer Portal Session Request.
 *
 * Creates a session of the customer portal
 *
 */
class CreateCustomerPortalSessionRequest extends AbstractRequest
{

    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }

    public function setReturnUrl($value)
    {
        $this->setParameter('return_url', $value);
    }

    public function getData()
    {
        $data = [];
        $data['customer']   = $this->getCustomerReference();
        $data['return_url'] = $this->getReturnUrl();

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/billing_portal/sessions';
    }
}
