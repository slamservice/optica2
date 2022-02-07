<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute deve essere accettato.',
    'accepted_if' => ':attribute deve essere accettato quando :other è :value.',
    'active_url' => ':attribute non è un URL valido.',
    'after' => ':attribute deve essere una data successiva al :date.',
    'after_or_equal' => ':attribute deve essere una data successiva o uguale al :date.',
    'alpha' => ':attribute deve contenere solo lettere.',
    'alpha_dash' => ':attribute deve contenere solo lettere, numeri, trattini e trattini bassi.',
    'alpha_num' => ':attribute deve contenere solo lettere e numeri.',
    'array' => ':attribute deve essere un array.',
    'before' => ':attribute deve essere una data precedente al :date.',
    'before_or_equal' => ':attribute deve essere una data precedente o uguale al :date.',
    'between' => [
        'numeric' => ':attribute deve essere compreso tra :min e :max.',
        'file' => ':attribute deve essere compreso tra :min e :max kilobytes.',
        'string' => ':attribute deve essere compreso tra :min e :max caratteri.',
        'array' => ':attribute must have between :min and :max items.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso.',
    'confirmed' => 'Il campo di conferma per :attribute non coincide.',
    'current_password' => 'La password non è corretta',
    'date' => ':attribute non è una data valida.',
    'date_equals' => ':attribute deve essere una data uguale a :date.',
    'date_format' => ':attribute non coincide con il formato :format.',
    'declined' => ':attribute deve essere rifiutato.',
    'declined_if' => ':attribute deve essere rifiutato quando :other è :value.',
    'different' => ':attribute e :other devono essere differenti.',
    'digits' => ':attribute deve essere di :digits cifre.',
    'digits_between' => ':attribute deve essere tra :min e :max cifre.',
    'dimensions' => 'Le dimensioni dell\'immagine di :attribute non sono valide.',
    'distinct' => ':attribute contiene un valore duplicato.',
    'email' => ':attribute deve essere un indirizzo email valido.',
    'ends_with' => ':attribute deve terminare con uno dei seguenti: :values.',
    'enum' => ':attribute selezionato non è valido.',
    'exists' => ':attribute selezionato non è valido.',
    'file' => ':attribute deve essere un file .',
    'filled' => 'Il campo :attribute deve avere un valore .',
    'gt' => [
        'numeric' => ':attribute deve essere maggiore di :value.',
        'file' => 'La dimensione di :attribute deve essere maggiore di :value kilobytes.',
        'string' => ':attribute deve avere più di :value caratteri.',
        'array' => ':attribute deve avere più di :value elementi.',
    ],
    'gte' => [
        'numeric' => ':attribute deve essere maggiore o uguale a :value.',
        'file' => 'La dimensione di :attribute deve essere maggiore o uguale a :value kilobytes.',
        'string' => ':attribute deve avere più o uguale a :value caratteri.',
        'array' => ':attribute deve avere :value elementi o più.',
    ],
    'image' => ':attribute deve essere un\' immagine.',
    'in' => ':attribute selezionato non è valido.',
    'in_array' => 'Il valore del campo :attribute non esiste in :other.',
    'integer' => ':attribute deve essere un numero intero.',
    'ip' => ':attribute deve essere un indirizzo IP valido.',
    'ipv4' => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => ':attribute deve essere un indirizzo IPv6 valido.',
    'mac_address' => ':attribute deve essere un MAC address valido.',
    'json' => ':attribute deve essere una stringa JSON valida.',
    'lt' => [
        'numeric' => ':attribute non può essere inferiore a :value.',
        'file' => 'Le dimensioni di :attribute non possono essere inferiori a :value kilobytes.',
        'string' => ':attribute non può avere meno di :value caratteri.',
        'array' => ':attribute non può avere meno di :value elementi.',
    ],
    'lte' => [
        'numeric' => ':attribute non può essere inferiore o uguale a :value.',
        'file' => 'le dimensioni di :attribute non possono essere inferiori o uguali a :value kilobytes.',
        'string' => ':attribute non può avere meno o uguali a :value caratteri.',
        'array' => ':attribute non può avere meno o uguale a :value elementi.',
    ],
    'max' => [
        'numeric' => ':attribute non può essere superiore a :max.',
        'file' => 'Le dimensioni di :attribute non possono essere superiori a :max kilobytes.',
        'string' => ':attribute non può avere più di :max caratteri.',
        'array' => ':attribute non può avere più di :max elementi.',
    ],
    'mimes' => ':attribute deve essere del tipo: :values.',
    'mimetypes' => ':attribute deve essere del tipo: :values.',
    'min' => [
        'numeric' => ':attribute deve essere almeno di :min.',
        'file' => 'Le dimensioni di :attribute devono essere almeno di :min kilobytes.',
        'string' => ':attribute deve avere almeno :min caratteri.',
        'array' => ':attribute deve avere almeno :min elementi.',
    ],
    'multiple_of' => ':attribute deve essere un multiplo di :value.',
    'not_in' => 'Il valore selezionato per :attribute non è valido.',
    'not_regex' => 'Il formato selezionato per :attribute non è valido.',
    'numeric' => ':attribute deve essere un numero.',
    'password' => 'La password non è corretta.',
    'present' => 'Il campo :attribute deve essere presente.',
    'prohibited' => 'Il campo :attribute è vietato.',
    'prohibited_if' => 'Il campo :attribute è vietato quando :other è :value.',
    'prohibited_unless' => 'Il campo :attribute è vietato salvo che :other sia compreso in :values.',
    'prohibits' => 'Il campo :other non può essere presente se è presente :attribute.',
    'regex' => 'Il formato :attribute non è valido.',
    'required' => 'Il campo :attribute è obbligatorio.',
    'required_if' => 'Il campo :attribute è obbligatorio se :other è :value.',
    'required_unless' => 'Il campo :attribute è obbligatorio salvo che :other sia compreso in :values.',
    'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
    'required_without' => 'Il campo :attribute è obbligatorio quando :values non sono presenti.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno di :values sono presenti.',
    'same' => ':attribute e :other devono coincidere.',
    'size' => [
        'numeric' => ':attribute deve essere :size.',
        'file' => 'Le dimensioni di :attribute devono essere :size kilobytes.',
        'string' => ':attribute deve avere :size caratteri.',
        'array' => ':attribute deve avere :size elementi.',
    ],
    'starts_with' => ':attribute deve iniziare con uno dei seguenti valori: :values.',
    'string' => ':attribute deve essere una stringa.',
    'timezone' => ':attribute deve essere una zona valida.',
    'unique' => ":attribute esiste già.",
    'uploaded' => ':attribute caricamento non riuscito.',
    'url' => ':attribute deve essere un URL valido.',
    'uuid' => ':attribute deve essere un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'messaggio-personalizzato',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
