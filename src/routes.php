<?php
// Routes

$app->get('/version/{application_id}/{secret}', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("GET");

    $application_id = filter_var($args['application_id'], FILTER_SANITIZE_STRING);
    $secret = filter_var($args['secret'], FILTER_SANITIZE_STRING);

    $manager = new ApplicationManager($this->db);
    $application = $manager->getApplicationById($application_id);
    if (!$application) {
        return $response->withStatus(404);;
    }
    if (!$application->secret == $secret) {
    	return $response->withStatus(403);;	
    }

    // Render index view
    return $response->write($application->version);
});

$app->post('/version', function ($request, $response, $args) {
    $data = $request->getParsedBody();

    $version = filter_var(@$data['version'], FILTER_SANITIZE_NUMBER_INT);
    $application_id = filter_var(@$data['application_id'], FILTER_SANITIZE_STRING);
    $secret = filter_var($data['secret'], FILTER_SANITIZE_STRING);

    if (!$application_id) {
        return $response->withStatus(400);
    }

    $manager = new ApplicationManager($this->db);
    $application = $manager->getApplicationById($application_id);
    if (!$application) {
        return $response->withStatus(404);;
    }
    if (!$application->secret == $secret) {
        return $response->withStatus(403);; 
    }

    if ($version) {
        if ($version > $application->version) {
            $application->version = $version;
            $manager->update($application);
        }
    }
    else {
        $application->version++;
        $manager->update($application);
    }

    // Render index view
    return $response->write($application->version);
});


$app->post('/manage/add/', function ($request, $response, $args) {
    $data = $request->getParsedBody();

    $application_id = filter_var($data['application_id'], FILTER_SANITIZE_STRING);
    $secret = filter_var($data['secret'], FILTER_SANITIZE_STRING);

    if (!$application_id || !$secret) {
    	return $response->withStatus(400);
    }

    $manager = new ApplicationManager($this->db);
    $application = $manager->getApplicationById($application_id);
    if ($application) {
        return $response->withStatus(409);
    }

    $application = new Application(array('application_id' => $application_id, 'secret' => $secret));
    $manager->insert($application);

    // Render index view
    return $response->write("OK");
});