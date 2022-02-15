<?php
return [
    'dependencies' => [
        'aliases' => [
            'doctrine.entity_manager.orm_default' => \Doctrine\ORM\EntityManagerInterface::class,
        ],
        'factories' => [
            \Doctrine\ORM\EntityManagerInterface::class => \ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
    ],
];