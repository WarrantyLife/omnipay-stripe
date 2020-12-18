<?php

/**
 * Stripe Create Subscription Request.
 */

namespace Omnipay\Stripe\Message;

/**
 * Stripe Create Subscription Request
 *
 * @see \Omnipay\Stripe\Gateway
 * @link https://stripe.com/docs/api/php#create_subscription
 */
class CreateSubscriptionRequest extends AbstractRequest
{
    /**
     * Get the plan
     *
     * @return string
     */
    public function getPlan()
    {
        return $this->getParameter('plan');
    }

    /**
     * Set the plan
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setPlan($value)
    {
        return $this->setParameter('plan', $value);
    }

    /**
     * Get quantity
     * @return int
     */
    public function getQuantity()
    {
        return $this->getParameter('quantity') ?: 1;
    }

    /**
     * Set the quantity
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setQuantity($value)
    {
        return $this->setParameter('quantity', $value);
    }

    /**
     * Get the tax percent
     *
     * @return string
     */
    public function getTaxPercent()
    {
        return $this->getParameter('tax_percent');
    }

    /**
     * Set the tax percentage
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setTaxPercent($value)
    {
        return $this->setParameter('tax_percent', $value);
    }

    /**
     * Get the the trial end timestamp
     * @return int
     */
    public function getTrialEnd()
    {
        return $this->getParameter('trial_end');
    }

    /**
     * Set the trial end timestamp.
     *
     * @param int $value
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setTrialEnd($value)
    {
        return $this->setParameter('trial_end', $value);
    }

    /**
     * @return array
     */
    public function getPhases()
    {
        return $this->getParameter('phases');
    }

    /**
     * If this is set then a subscription schedule is created, which implicitly creates a subscription
     * @param array $value
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setPhases($value)
    {
        return $this->setParameter('phases', $value);
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->getParameter('start_date');
    }

    /**
     * Set the plan
     *
     * @param $value
     * @return \Omnipay\Common\Message\AbstractRequest|CreateSubscriptionRequest
     */
    public function setStartDate($value)
    {
        return $this->setParameter('start_date', $value);
    }

    public function getData()
    {
        $this->validate('customerReference');

        if($phases = $this->getPhases()) {
            for($i=0; $i<count($phases); $i++) {
                $data['phases['.$i . ']'] = $phases[$i];
            }
            $data['customer'] = $this->getCustomerReference();
        } else {
            $data = [
                'items[0][price]' => $this->getPlan(),
                'items[0][quantity]' => $this->getQuantity()
            ];
        }

        if ($this->parameters->has('start_date')) {
            $data['start_date'] = $this->getParameter('start_date');
        }

        if ($this->parameters->has('tax_percent')) {
            $data['tax_percent'] = $this->getParameter('tax_percent');
        }

        if ($this->getMetadata()) {
            $data['metadata'] = $this->getMetadata();
        }

        if ($this->getTrialEnd()) {
            $data['trial_end'] = $this->getTrialEnd();
        }
        return $data;
    }

    public function getEndpoint()
    {
        if($this->getPhases()) {
            return $this->endpoint.'/subscription_schedules';
        } else {
            return $this->endpoint . '/customers/' . $this->getCustomerReference() . '/subscriptions';
        }
    }
}
