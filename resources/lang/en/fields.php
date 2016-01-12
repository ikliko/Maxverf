<?php
/**
 * Created by PhpStorm.
 * User: kliko
 * Date: 12/15/15
 * Time: 8:37 AM
 */

return [

    'menu' => [
        'index' => 'Home',
        'shop' => 'Shop',
        'promotions' => 'Promotions',
        'news' => 'Latest',
        'conditional_terms' => 'Customer service',
    ],

    'login' => [
        'title' => 'Login',
        'email' => [
            'label' => 'E-mail',
            'placeholder' => 'E-mail',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Password',
        ],
        'submit_btn' => 'Login',
    ],

    'register' => [
        'title' => 'Register',
        'email' => [
            'label' => 'E-mail',
            'placeholder' => 'E-mail',
        ],
        'account_type' => [
            'label' => 'account type',
            'radio' => [
                'firm' => 'firm',
                'personal' => 'personal',
            ]
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Password',
        ],
        'confirm_password' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm Password',
        ],
        'confirm_btn' => 'Register',
    ],

    'slider' => [
        'info_btn' => 'Details',
        'buy_btn' => 'Buy',
    ],

    'index' => [
        'title' => 'WELKOM BIJ MAX VERFGROOTHANDEL',
        'text' => [
            'De winkel voor professionele vakschilders,stukadoors en particulieren. In onze winkel treft U een groot assortiment verf van topkwaliteit tegen gunstige prijzen! Onze bedrijfsslogan is "Kwaliteit kan goedkoper" en dat meen we echt!Kwaliteit kan inderdaad minder kosten. We hebben kwalitatieve muurverven voor binnen en buiten,grond- en aflakverven,kwasten,rollen, plamuurkitten,acrylaatkitten,stukloop etc.. een hele grote gamma van non-paint producten voor vakschilders en stukadoors. Daarnaast hebben we een uitgebreide gamma van tegellijmen,egalisatiemortels en tegels voor veel lagere prijzen! Kwaliteit is Gegarandeerd!',
            'Voor meer informatie kunt U terecht op onze website of op tel. nummer 06 11 530353. Natuurlijk Bent U ook van harte welkom in onze mooie winkel op Zuiddijk 101 in Zaandam. De koffie staat klaar!!!',
        ],
    ],

    'promotions' => [
        'title' => 'items',
        'buy_btn' => 'add to cart',
        'info_btn' => 'Details',
    ],

    'news' => [
        'title' => 'items',
    ],

    'conditional_terms' => [
        'title' => 'Max Verf Customer service',
        'contacts' => [
            'title' => 'contacts',
            'subtitle' => 'MaxVerf Groothandel BV',
            'worktime' => 'Onze werktijden',
            'coc' => 'COC number',
            'vat' => 'VAT number',
            'iban' => 'bank details',
        ],
        'courier' => [
            'title' => 'shipping',
            'text' => [
                'Wij gebruiken verschillende verzendmethodes:',
                '- Verzending via <strong> transportbedrijf </strong> (bij grote pakketten)',
                '<strong> Afhalen</strong> op Zuiddijk 101, 1501 CD Zaandam',
                '<strong>Levertijd transportbedrijf</strong>',
                'Ook het transportbedrijf levert in 99 procent van de gevallen binnen 24 uur nadat het bij ons verstuurd is. Vergeet niet om je telefoonnummer te vermelden bij je contactgegevens, zodat de chauffeur je kan bereiken.',
                '<strong>Wij bezorgen ook op zaterdag</strong>',
                '<strong>Verzendkosten</strong>',
                'Bestellingen boven 250 euro worden gratis bezorgd. Voor bestellingen minderdan 250 euro worden 50 euro bezorgkosten berekend'
            ],
        ],
        'payment' => [
            'title' => 'payment options',
            'text' => [
                'Betaalmogelijkheden',
                'Bij MaxVerf.nl kan je de online aankopen op verschillende manieren afrekenen. Wij hanteren de volgende betaalmogelijkheden.',
            ],
            'ideal' => [
                'title' => 'Ideal',
                'elements' => [
                    'Alleen klanten met een Nederlandse bankrekening kunnen via Ideal betalen',
                    'Je betaalt direct tijdens het bestelproces via je eigen bank',
                    'Je betaalt in je eigen vertrouwde internetbetaalomgeving',
                    'Er is geen registratie of account nodig om te betalen',
                    'Het is belangrijk dat het hele betalingsproces wordt afgerond, totdat je weer op de Ecotools website bent',
                ]
            ],
            'bank' => [
                'title' => 'prepay',
                'elements' => [
                    'Je betaalt nadat je online hebt besteld',
                    'Per mail ontvang je een bevestiging van de bestelling, met daarin alle gegevens die nodig zijn om de betaling te verrichten',
                    'Wegens administratieve handelingen verwerken wij de bestelling niet op de dag van bestelling, maar een dag later.',
                    'Als wij de betaling hebben ontvangen (dit duurt meestal enkele dagen), versturen wij je bestelling.'
                ],
            ],
            'delivery' => [
                'title' => 'cash on delivery',
                'elements' => [
                    'Je betaalt bij aflevering van de bestelling',
                    'Je kan bij betaling onder rembours alleen contant aan de chauffeur betalen',
                ],
            ],
            'cash' => [
                'title' => 'Cash payment on pickup',
                'elements' => [
                    'Je betaalt zodra je de bestelling bij ons ophaalt',
                    'Je kunt het totaalbedrag pinnen of contant betalen'
                ]
            ]
        ]
    ],

    'product' => [
        'size' => 'size',
        'color' => 'color',
        'qty' => 'quantity',
        'buy_btn' => 'add to cart',
        'description' => 'description',
        'incl' => 'price incl. vat',
        'excl' => 'price excl. vat',
        'promo' => [
            'incl' => 'Promo price incl BTW',
            'excl' => 'Promo price excl BTW',
        ]
    ],

    'cart' => [
        'title' => 'Cart',
        'product' => 'product',
        'size' => 'size',
        'color' => 'color',
        'price' => 'price',
        'qty' => 'quantity',
        'subtotal' => 'subtotal',
        'total' => 'total',
        'back_btn' => 'continue shopping',
        'continue_btn' => 'Order'
    ],

    'order' => [
        'title' => 'Payment details',
        'card' => [
            'title' => 'Payment by credit card',
            'description' => [
                'Free delivery',
                'Payment by bank transfer you will be redirected to PayU upon completion of contract'
            ]
        ],

        'easypay' => [
            'title' => 'Payment through EasyPay',
            'description' => [
                'Free delivery',
                'Payment is made in cash EasyPay, an ATM service with B-pay or online epay.bg'
            ]
        ],

        'delivery' => [
            'title' => 'Cash on Delivery',
            'description' => [
                'Free delivery',
                'When paying by cash is payable amount for its administrative processing at a rate of 4.99 lev',
                'In no other methods fees',
                'Payment is due upon receipt of the sections'
            ]
        ],
        'back_btn' => 'Back',
        'continue_btn' => 'Continue',
    ],

    'order_person' => [
        'first_name' => [
            'label' => 'first name',
            'placeholder' => 'first name',
        ],
        'last_name' => [
            'label' => 'last name',
            'placeholder' => 'last name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Email',
        ],
        'phone' => [
            'label' => 'phone',
            'placeholder' => 'phone',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'City',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Address',
        ],
        'comment' => [
            'label' => 'comment',
            'placeholder' => 'comment',
        ],
        'continue_btn' => 'Confirm'
    ],

    'order_firm' => [
        'firm' => [
            'label' => 'Bedrijfsnaam',
            'placeholder' => 'Bedrijfsnaam',
        ],
        'first_name' => [
            'label' => 'first name',
            'placeholder' => 'first name',
        ],
        'last_name' => [
            'label' => 'last name',
            'placeholder' => 'last name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Email',
        ],
        'phone' => [
            'label' => 'phone',
            'placeholder' => 'phone',
        ],
        'kvk' => [
            'label' => 'coc number',
            'placeholder' => 'coc number',
        ],
        'vat' => [
            'label' => 'vat number',
            'placeholder' => 'vat number',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'City',
        ],
        'firm_address' => [
            'label' => 'company address',
            'placeholder' => 'company address',
        ],
        'delivery_address' => [
            'label' => 'delivery address',
            'placeholder' => 'delivery address',
        ],
        'comment' => [
            'label' => 'comment',
            'placeholder' => 'comment',
        ],
        'continue_btn' => 'Confirm'
    ],

    'shop' => [
        'title' => 'ARTIKELEN',
        'info_btn' => 'Details',
        'buy_btn' => 'Buy',
    ],

    'categories' => [
        'title' => 'categories',
    ],

    'last_section' => [
        'title' => 'latest',
        'info_btn' => 'details',
        'buy_btn' => 'buy',
    ],

    'promotion_section' => [
        'title' => 'promotions',
        'info_btn' => 'details',
        'buy_btn' => 'buy',
    ],

    'thanks' => [
        'Your order has been received and will be processed soon',
        'Thank you for choosing MaxVerf'
    ],

    'error' => [
        'ERROR ! PLEASE TRY AGAIN',
    ],

    '404' => [
        'title' => 'page not found',
        'link' => 'go back'
    ],

    'copyright' => 'All rights reserved',

    'search' => [
        'placeholder' => 'search within MaxVerf'
    ]
];