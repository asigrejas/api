<?php

class VisitUrlTest extends TestCase
{
    /**
     * Verifica se a rota está inicial está funcionando.
     */
    public function testVisitUrl()
    {
        $this->visit('/')
            ->see('As Igrejas V 1.0');
    }
}
