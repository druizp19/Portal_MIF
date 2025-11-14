<?php

return [
    'sistemas' => [
        'FUERZA DE VENTA' => [
            'nombre' => 'Fuerza de Venta',
            'descripcion' => 'Sistema de gestión de fuerza de venta',
            'icono' => '👥',
            'url' => env('SISTEMA_FFVV_URL', 'http://localhost:8003')
        ],
        'CONFIGURACION DE MERCADO' => [
            'nombre' => 'Configuración de Mercado',
            'descripcion' => 'Gestión y configuración de mercados',
            'icono' => '⚙️',
            'url' => env('SISTEMA_CONFIG_MERCADO_URL', 'http://localhost:8002')
        ],
        'PLATAFORMA BI' => [
            'nombre' => 'Plataforma BI',
            'descripcion' => 'Business Intelligence y reportes',
            'icono' => '📊',
            'url' => env('SISTEMA_PLATAFORMA_BI_URL', 'http://localhost:8001')
        ]
    ]
];
