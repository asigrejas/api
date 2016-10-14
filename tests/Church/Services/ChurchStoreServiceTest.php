<?php

namespace Church\Services;

use App;
use Church\Church;
use Church\Repositories\ChurchRepository;
use Mockery as m;
use TestCase;

class ChurchStoreServiceTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    /**
     * Teste para falhar ao tentar salvar uma nova igreja.
     */
    public function testFailSaveNewChurch()
    {
        // Set
        $addresses = [];
        $data = ['addresses' => $addresses];

        $churchRepo = m::mock(ChurchRepository::class);
        $store = new ChurchStoreService($churchRepo);

        // Expect
        $churchRepo->shouldReceive('store')
            ->once()
            ->with($data)
            ->andReturn(false);

        $store->store($data);

        // Asserts
        $this->assertTrue($store->fails());
    }

    /**
     * Teste para salvar uma nova igreja.
     */
    public function testSaveNewChurch()
    {
        // Set
        $addresses = [];
        $data = ['addresses' => $addresses];

        $churchRepo = m::mock(ChurchRepository::class);
        $addressRepo = m::mock(AddressRepository::class);
        $store = new ChurchStoreService($churchRepo, $addressRepo);

        // Expect
        $churchRepo->shouldReceive('store')
            ->once()
            ->with($data)
            ->andReturn(true);

        $store->store($data);

        // Asserts
        $this->assertFalse($store->fails());
    }

    /**
     * Cria uma nova igreja no db.
     */
    public function testStoreChurch()
    {
        // Set
        $addresses = [
            'street' => 'Avenida Guilherme Ferreira',
            'number' => 361,
            'city' => 'Uberaba',
            'state' => 'BR-MG',
            'country' => 'Brazil',
        ];
        $data = ['name' => 'igreja de teste', 'addresses' => [$addresses]];
        $data = ['id' => 'teste', 'name' => 'igreja de teste', 'addresses' => [$addresses]];

        $churchRepository = App::make(ChurchRepository::class);
        $addressRepository = App::make(AddressRepository::class);
        $store = new ChurchStoreService($churchRepository, $addressRepository);

        $store->store($data);

        // Asserts
        $this->assertTrue($store->passes());
    }
}
