<?php
return array(
    'router' => array(
        'routes' => array(
            'tocat-api.rest.project' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/v1/project[/:project_id]',
                    'defaults' => array(
                        'controller' => 'TocatApi\\V1\\Rest\\Project\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'tocat-api.rest.project',
        ),
    ),
    'zf-rest' => array(
        'TocatApi\\V1\\Rest\\Project\\Controller' => array(
            'listener' => 'TocatApi\\V1\\Rest\\Project\\ProjectResource',
            'route_name' => 'tocat-api.rest.project',
            'route_identifier_name' => 'project_id',
            'collection_name' => 'project',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'TocatApi\\V1\\Rest\\Project\\ProjectEntity',
            'collection_class' => 'TocatApi\\V1\\Rest\\Project\\ProjectCollection',
            'service_name' => 'project',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'TocatApi\\V1\\Rest\\Project\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'TocatApi\\V1\\Rest\\Project\\Controller' => array(
                0 => 'application/vnd.tocat-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'TocatApi\\V1\\Rest\\Project\\Controller' => array(
                0 => 'application/vnd.tocat-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'TocatApi\\V1\\Rest\\Project\\ProjectEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tocat-api.rest.project',
                'route_identifier_name' => 'project_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'TocatApi\\V1\\Rest\\Project\\ProjectCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'tocat-api.rest.project',
                'route_identifier_name' => 'project_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(
            'TocatApi\\V1\\Rest\\Project\\ProjectResource' => array(
                'adapter_name' => 'dbBase',
                'table_name' => 'project',
                'hydrator_name' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'TocatApi\\V1\\Rest\\Project\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'TocatApi\\V1\\Rest\\Project\\ProjectResource\\Table',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'TocatApi\\V1\\Rest\\Project\\Controller' => array(
            'input_filter' => 'TocatApi\\V1\\Rest\\Project\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'TocatApi\\V1\\Rest\\Project\\Validator' => array(
            0 => array(
                'name' => 'id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Project Identificator, string [A-z]',
                'error_message' => 'Only alphabetical',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ),
            1 => array(
                'name' => 'budget',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
                'description' => 'Total cost for project',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'error_message' => 'Should be positive float number',
            ),
        ),
    ),
);
