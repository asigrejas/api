<?php

namespace Church\Http\Requests;

use App\Http\Requests\Request;

class ChurchStoreRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = parent::all();

        $rules = [
            'name' => 'required|max:255',
            'ministry' => 'max:255',
            'phone1' => 'max:15',
            'phone2' => 'max:15',
            'phone3' => 'max:15',
            'cnpj' => 'max:14|cnpj',
            'email' => 'max:255|email',
            'comments' => 'max:65535',
            'online' => 'boolean',
            'addresses' => 'required_if:online,false,0|required_without:online|array',
        ];

        /*
         * Verifica se foram passados endereços
         * Caso contrário devolver as regras
         */
        if (!isset($input['addresses']) || !is_array($input['addresses'])) {
            return $rules;
        }

        /*
         * Regras para validação dos addresses(endereços)
         * @var array
         */
        $addressesRules = [
            'title' => 'max:255',
            'zipcode' => 'max:10',
            'street' => 'required|max:255',
            'number' => 'integer|max:99999',
            'district' => 'max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'phone1' => 'max:15',
            'phone2' => 'max:15',
            'phone3' => 'max:15',
            'email' => 'email',
            'website' => 'max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'comments' => 'max:65535',
        ];

        /*
         * @var array
         */
        $addresses = $input['addresses'];

        /*
         * varre a array de addresses e verifica se todos os campos
         * de "rules" foram informados
         *
         * @var array
         */
        $newRules = [];
        foreach ($addresses as $row => $address) {
            /*
             * varre rules para verificar as keys e
             * o tipo de validação configurada, e adiciona nas novas rules
             * @var array
             */
            foreach ($addressesRules as $key => $value) {
                $newRules['addresses.'.$row.'.'.$key] = $value;
            }
        }

        return array_merge($rules, $newRules);
    }

    public function messages()
    {
        $input = parent::all();

        $messages = [
            'name.required' => 'Nome da igreja obrigatório',
            'name.max' => 'Nome deve ter no máximo :max caracteres',
            'ministry.max' => 'Ministério deve ter no :max caracteres',
            'phone1.max' => 'Telefone 1 deve ter no máximo :max caracteres',
            'phone2.max' => 'Telefone 2 deve ter no máximo :max caracteres',
            'phone3.max' => 'Telefone 3 deve ter no máximo :max caracteres',
            'cnpj.max' => 'CNPJ deve ter no máximo :max caracteres',
            'cnpj.cnpj' => 'CNPJ inválido',
            'email.max' => 'Email deve ter no máximo :max caracteres',
            'email.email' => 'Email inválido',
            'comments.max' => 'Comentários deve ter no máximo :max',
            'online.boolean' => 'Online deve ser verdadeiro ou falso',
            'addresses.required_if' => 'Se a igreja não for online é obrigatório informar um endereço',
            'addresses.required_without' => 'Se a igreja não for online é obrigatório informar um endereço',
            'addresses.array' => 'Endereço precisa ser um conjunto',
        ];

        /*
         * Verifica se foram passados endereços
         * Caso contrário devolver as regras
         */
        if (!isset($input['addresses']) || !is_array($input['addresses'])) {
            return $messages;
        }

        /*
         * Messages para validação dos addresses(endereços)
         * @var array
         */
        $addressesMessages = [
            'title.max' => 'Título deve ter no máximo :max',
            'zipcode.max' => 'CEP deve ter no máximo :max',
            'street.required' => 'Logradouro é obrigatório',
            'street.max' => 'Logradouro deve ter no máximo :max',
            'number.integer' => 'integer',
            'number.max' => 'Deve ter o número máximo de :max',
            'district.max' => 'Bairro deve ter no máximo :max caracteres',
            'city.required' => 'Cidade é obrigatória',
            'city.max' => 'Cidade deve ter no máximo :max caracteres',
            'state.required' => 'Estado é obrigatório',
            'state.max' => 'Estado deve ter no máximo :max caracteres',
            'country.required' => 'País é obrigatório',
            'country.max' => 'País deve ter no máximo :max caracteres',
            'phone1.max' => 'Telefone 1 deve ter no máximo :max caracteres',
            'phone2.max' => 'Telefone 2 deve ter no máximo :max caracteres',
            'phone3.max' => 'Telefone 3 deve ter no máximo :max caracteres',
            'email.max' => 'Email deve ter no máximo :max caracteres',
            'email.email' => 'Email inválido',
            'comments.max' => 'Comentários deve ter no máximo :max',
            'website.max' => 'Website deve ter no máximo :max',
            'latitude.numeric' => 'Latitude deve ser um valor numérico',
            'longitude.numeric' => 'Longitude deve ser um valor numérico',
        ];

        /*
         * @var array
         */
        $addresses = $input['addresses'];

        /*
         * varre a array de addresses e verifica se todos os campos
         * de "messages" foram informados
         *
         * @var array
         */
        $newRules = [];
        foreach ($addresses as $row => $address) {
            /*
             * varre messages para verificar as keys e
             * o tipo de validação configurada, e adiciona nas novas messages
             * @var array
             */
            foreach ($addressesMessages as $key => $value) {
                $newRules['addresses.'.$row.'.'.$key] = ($row + 1).': '.$value;
            }
        }

        return array_merge($messages, $newRules);
    }
}
