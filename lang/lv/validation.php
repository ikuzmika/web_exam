<?php

return [
    'required' => 'Lauks ":attribute" ir obligāts.',
    'required_with' => 'Lauks ":attribute" ir obligāts, ja ir aizpildīts ":values".',
    'string' => 'Laukam ":attribute" jābūt tekstam.',
    'email' => 'Laukam ":attribute" jābūt derīgai e-pasta adresei.',
    'max' => [
        'string' => 'Lauks ":attribute" nedrīkst būt garāks par :max rakstzīmēm.',
        'file' => 'Fails ":attribute" nedrīkst būt lielāks par :max kilobaitiem.',
    ],
    'min' => [
        'string' => 'Laukam ":attribute" jābūt vismaz :min rakstzīmēm garam.',
    ],
    'unique' => 'Šāda ":attribute" vērtība jau eksistē.',
    'confirmed' => 'Lauka ":attribute" apstiprinājums nesakrīt.',
    'in' => 'Izvēlētā ":attribute" vērtība nav derīga.',
    'exists' => 'Izvēlētā ":attribute" vērtība nav derīga.',
    'image' => 'Laukam ":attribute" jābūt attēlam.',
    'mimes' => 'Failam ":attribute" jābūt vienā no šiem formātiem: :values.',
    'boolean' => 'Laukam ":attribute" jābūt patiess vai nepatiess vērtībai.',
    'nullable' => 'Lauks ":attribute" var būt tukšs.',

    'attributes' => [
        'name' => 'vārds',
        'email' => 'e-pasts',
        'phone' => 'telefons',
        'password' => 'parole',
        'password_confirmation' => 'paroles apstiprinājums',
        'current_password' => 'pašreizējā parole',
        'role' => 'loma',

        'title' => 'nosaukums',
        'description' => 'apraksts',
        'photo' => 'fotogrāfija',
        'competition_id' => 'sacensības',
        'track_id' => 'trase',
        'pair_id' => 'pāris',
        'size_category_id' => 'suņa izmērs',
        'difficulty_level_id' => 'grūtības līmenis',
        'result_status_id' => 'rezultāta statuss',
        'points' => 'punkti',
        'date' => 'datums',
        'venue' => 'norises vieta',
    ],
];
