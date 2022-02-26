<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return response()->json(['status' => 'OK']);
});
/**
 * post addplayer
 * Summary: Add a new player to the store
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->post('player', 'PlayerApi@addPlayer');
/**
 * put updateplayer
 * Summary: Update an existing player
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->put('player', 'PlayerApi@updatePlayer');
/**
 * get findplayersByStatus
 * Summary: Finds players by status
 * Notes: Multiple status values can be provided with comma separated strings
 * Output-Formats: [application/json, application/xml]
 */
$router->get('player/findByStatus', 'PlayerApi@findplayersByStatus');
/**
 * get findplayersByTags
 * Summary: Finds players by tags
 * Notes: Muliple tags can be provided with comma separated strings. Use\\ \\ tag1, tag2, tag3 for testing.
 * Output-Formats: [application/json, application/xml]
 */
$router->get('player/findByTags', 'PlayerApi@findplayersByTags');

/**
 * get getAll
 * Summary: Finds all players
 *
 * Output-Formats: [application/json]
 */
$router->get('player', 'PlayerApi@getAll');
/**
 * delete deleteplayer
 * Summary: Deletes a player
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->delete('player/{playerId}', 'PlayerApi@deletePlayer');
/**
 * get getplayerById
 * Summary: Find player by ID
 * Notes: Returns a single player
 * Output-Formats: [application/json, application/xml]
 */
$router->get('player/{playerId}', 'PlayerApi@getPlayerById');
/**
 * post updateplayerWithForm
 * Summary: Updates a player in the store with form data
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->post('player/{player_id}', 'PlayerApi@updateplayerWithForm');
/**
 * post uploadFile
 * Summary: uploads an image
 * Notes:
 * Output-Formats: [application/json]
 */
$router->post('player/{player_id}/uploadImage', 'PlayerApi@uploadFile');
/**
 * post createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$router->post('user', 'UserApi@createUser');
/**
 * post createUsersWithArrayInput
 * Summary: Creates list of users with given input array
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->post('user/createWithArray', 'UserApi@createUsersWithArrayInput');
/**
 * post createUsersWithListInput
 * Summary: Creates list of users with given input array
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->post('user/createWithList', 'UserApi@createUsersWithListInput');
/**
 * get loginUser
 * Summary: Logs user into the system
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->get('user/login', 'UserApi@loginUser');
/**
 * get logoutUser
 * Summary: Logs out current logged in user session
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->get('user/logout', 'UserApi@logoutUser');
/**
 * delete deleteUser
 * Summary: Delete user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$router->delete('user/{username}', 'UserApi@deleteUser');
/**
 * get getUserByName
 * Summary: Get user by user name
 * Notes:
 * Output-Formats: [application/json, application/xml]
 */
$router->get('user/{username}', 'UserApi@getUserByName');
/**
 * put updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$router->put('user/{username}', 'UserApi@updateUser');
