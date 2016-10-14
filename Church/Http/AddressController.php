<?php

namespace Church\Http;

use App\Http\Controllers\Controller;
use Church\Repositories\AddressRepository;

class AddressController extends Controller
{
    private $repo;
    private $with = ['church'];

    /**
     * @param AddressRepository $repo
     */
    public function __construct(AddressRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get all churches.
     *
     * @return AddressRepository
     */
    public function all()
    {
        $churches = $this->repo->allActive(['*'], $this->with);

        return $this->response($churches);
    }

    /**
     * Get church by id :id.
     *
     * @param  int $id
     *
     * @return AddressRepository
     */
    public function get($id)
    {
        $church = $this->repo->findActive($id, ['*'], $this->with);

        if ($church->count() < 1) {
            return $this->response('Failed', false);
        }

        return $this->response($church);
    }
}
