<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'name',
        'delete' => 'deleted',
        'descriptionColumn' => 'description',
        'rootLevel' => 1,
        'groupName' => 'system',
        'versioningWS_alwaysAllowLiveEdit' => true, // Only have LIVE records of file storages
        'typeicon_classes' => [
            'default' => 'mimetypes-x-sys_file_storage',
        ],
        'type' => 'driver',
    ],
    'columns' => [
        'name' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.name',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'max' => 255,
                'required' => true,
            ],
        ],
        'is_browsable' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.is_browsable',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'is_default' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.is_default',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'eval' => 'maximumRecordsChecked',
                'validation' => [
                    'maximumRecordsChecked' => 1,
                ],
            ],
        ],
        'is_public' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.is_public',
            'config' => [
                'default' => 1,
                'type' => 'user',
                'renderType' => 'userSysFileStorageIsPublic',
            ],
        ],
        'is_writable' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.is_writable',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'is_online' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.is_online',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'auto_extract_metadata' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.auto_extract_metadata',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'processingfolder' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.processingfolder',
            'description' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.processingfolder.placeholder',
            'config' => [
                'type' => 'input',
                'size' => 20,
            ],
        ],
        'driver' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.driver',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [],
                'default' => 'Local',
            ],
        ],
        'configuration' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_storage.configuration',
            'config' => [
                'type' => 'flex',
                'ds_pointerField' => 'driver',
                'ds' => [],
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    name, driver, configuration, is_default, auto_extract_metadata, processingfolder,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:accesscapabilities,
                    --palette--;Capabilities;capabilities,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    is_online,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                description,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        '],
    ],
    'palettes' => [
        'capabilities' => [
            'showitem' => 'is_browsable, is_public, is_writable',
        ],
    ],
];
