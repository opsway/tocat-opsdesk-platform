<?php
return array(
    'TocatApi\\V1\\Rest\\Project\\Controller' => array(
        'description' => 'API for projects budgets.',
        'collection' => array(
            'GET' => array(
                'description' => 'GET projects collection',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project"
       },
       "first": {
           "href": "/api/v1/project?page={page}"
       },
       "prev": {
           "href": "/api/v1/project?page={page}"
       },
       "next": {
           "href": "/api/v1/project?page={page}"
       },
       "last": {
           "href": "/api/v1/project?page={page}"
       }
   }
   "_embedded": {
       "project": [
           {
               "_links": {
                   "self": {
                       "href": "/api/v1/project[/:project_id]"
                   }
               }
              "project_id": "Project External Identificator, Integer",
              "budget": "Total cost for project",
              "uid": "Uniq autoincrement ID (internal)"
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'INSERT entity (project) in colection',
                'request' => '{
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project[/:project_id]"
       }
   }
   "id": "Project Identificator, string [A-z]",
   "budget": "Total cost for project"
}',
            ),
            'description' => 'Project Collection.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'GET info by project',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project[/:project_id]"
       }
   }
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
            ),
            'PATCH' => array(
                'description' => 'UPDATE partically project entity',
                'request' => '{
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project[/:project_id]"
       }
   }
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
            ),
            'PUT' => array(
                'description' => 'INSERT all data to exists entity',
                'request' => '{
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project[/:project_id]"
       }
   }
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
            ),
            'DELETE' => array(
                'description' => 'DELETE project entity',
                'request' => '{
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/api/v1/project[/:project_id]"
       }
   }
   "project_id": "Project External Identificator, Integer",
   "budget": "Total cost for project",
   "uid": "Uniq autoincrement ID (internal)"
}',
            ),
            'description' => 'Project entity',
        ),
    ),
);
