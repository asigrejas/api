<?php

namespace Church\Services;

use Church\Address;
use Church\Repositories\ChurchRepository;
use Domain\Criteria\Service;
use Exception;
use Library\GMaps;

class ChurchStoreService extends Service
{
    /**
     * @var ChurchRepository
     */
    private $repo;

    /**
     * @param ChurchRepository $repo
     */
    public function __construct(ChurchRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Store new church.
     *
     * @param  array  $data
     */
    public function store(array $data)
    {
        if (!isset($data['addresses']) || !is_array($data['addresses'])) {
            $this->setError('Endereço é obrigatório!');

            return;
        }

        $church = $this->repo->store($data);

        if (!$church) {
            $this->setError('Erro ao tentar salvar igreja.');

            return;
        }

        $addresses = $data['addresses'];

        foreach ($addresses as $row) {
            $maps = new GMaps();
            $add = $row['street'].', '.$row['number'].' - '.$row['district'].', '.$row['city'].' - '.$row['state'];
            if (isset($row['zipcode'])) {
                $zipcode = $row['zipcode'];
                $zipcode = preg_replace('/\D/', '', $zipcode);
                $add .= ', '.substr($zipcode, 0, 5).'-'.substr($zipcode, 5, 3);
            }
            $add .= ', '.$row['country'];

            $location = $maps->location($add);

            if (isset($location->lat) && isset($location->lng)) {
                $row['latitude'] = $location->lat;
                $row['longitude'] = $location->lng;
            }

            try {
                $address = new Address;
                $address->church_id = (int) $church->id;
                $address->fill($row);
                $church->addresses()->save($address);
            } catch (Exception $e) {
                $this->setError('Um ou mais endereços é inválido.');
                $this->repo->forceDelete($church->id);
            }
        }

        return $this;
    }
}
