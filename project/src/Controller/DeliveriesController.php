<?php

namespace Delivery\Controller;

use Delivery\Model\DeliveryQuery;
use Delivery\Repository\DeliveryRepository;
use Propel\Runtime\ActiveQuery\Criteria;

class DeliveriesController extends LayoutController
{
    public function get()
    {
        $limit           = $this->f('limit');
        $offset          = $this->f('offset');
        $count           = $this->f('count', false);
        $name            = $this->f('name');
        $has_email       = $this->f('has_email');
        $has_sms         = $this->f('has_sms');
        $has_feed        = $this->f('has_feed');
        $status          = $this->f('status');
        $created_at_from = $this->f('created_at_from');
        $created_at_to   = $this->f('created_at_to');

        if ($limit <= 0) {
            $limit = 0;
        }

        if ($offset <= 0) {
            $offset = 0;
        }

        $objs = DeliveryQuery::create()
            ->orderByCreatedAt(Criteria::DESC);

        if ($name) {
            $objs = $objs
                ->filterByName('%' . $name . '%', Criteria::ILIKE);
        }

        if (is_bool($has_email)) {
            if ($has_email) {
                $objs = $objs->filterByHasEmail(true);
            } else {
                $objs = $objs->filterByHasEmail(false);
            }
        }

        if (is_bool($has_sms)) {
            if ($has_sms) {
                $objs = $objs->filterByHasSms(true);
            } else {
                $objs = $objs->filterByHasSms(false);
            }
        }

        if (is_bool($has_feed)) {
            if ($has_feed) {
                $objs = $objs->filterByHasFeed(true);
            } else {
                $objs = $objs->filterByHasFeed(false);
            }
        }

        if ($status) {
            $objs = $objs
                ->filterByStatus($status);
        }

        if ($created_at_from) {
            $objs = $objs
                ->filterByCreatedAt($created_at_from . ' 00:00:00', Criteria::GREATER_EQUAL);
        }

        if ($created_at_to) {
            $objs = $objs->filterByCreatedAt(
                date('Y-m-d', strtotime($created_at_to . ' + 1 day')) .
                ' 00:00:00',
                Criteria::LESS_THAN
            );
        }

        if ($count) {
            $nb_results_query = clone $objs;
            $nb_results       = $nb_results_query->count();
        }

        if ($limit) {
            $objs = $objs
                ->limit($limit);
        }

        if ($offset) {
            $objs = $objs
                ->offset($offset);
        }

        $objs = $objs->find();

        /** @var DeliveryRepository $repository */
        $repository = $this->s('delivery.repository.delivery');

        $content = [
            'deliveries' => $repository->formatCollection($objs),
        ];

        if ($count) {
            $content['nb_results'] = (int) $nb_results;
        }

        $this->setContent($content);
    }
}
