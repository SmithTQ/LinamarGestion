<?php

class MenuItems {

    public $items = [
        "Campañas" => [
            "Pedidos" => [
                "Uri" => "#",
                "Icon" => "orders"
            ]
        ],
        "Administración" => [
            "Detalles" => [
                "Uri" => "detalles/listar",
                "Icon" => "featured_seasonal_and_gifts"
            ],
/*             "Clientes" => [
                "Uri" => "#",
                "Icon" => "person"
            ], */
            "Distritos" => [
                "Uri" => "distritos/listar",
                "Icon" => "map"
            ],
            "Formularios" => [
                "Uri" => "formularios/listar",
                "Icon" => "table_view"
            ]
        ]
    ];

}
