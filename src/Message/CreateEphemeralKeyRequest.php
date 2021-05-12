<?php

namespace Omnipay\Stripe\Message;

/**
 * Stripe Create Ephemeral Key Request.
 *
 * Creates an ephemeral key that acts as a temporary session key that mobile clients
 * can use to access the customer API
 *
 */
class CreateEphemeralKeyRequest extends AbstractRequest
{

    public function getData()
    {

        $this->setStripeVersion('2019-05-16');
        $data = [];
        $data['customer']   = $this->getCustomerReference();
        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/ephemeral_keys';
    }
}
