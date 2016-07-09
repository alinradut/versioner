<?php

class ApplicationManager {

    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function getApplicationById($applicationId) {
        $statement = $this->db->prepare("SELECT id, application_id, version, secret FROM applications WHERE application_id = :application_id");
        $statement->execute(array(':application_id' => $applicationId));
        if ($row = $statement->fetch()) {
            return new Application($row);
        }
    }

    public function insert(Application $application) {
    	$statement = $this->db->prepare("INSERT INTO applications (application_id, version, secret) VALUES (:application_id, :version, :secret)");
    	$result = $statement->execute(array(':application_id' => $application->applicationId, ':version' => $application->version, ':secret' => $application->secret));
    	if (!$result) {
    	    throw new Exception("Could not update version");
    	}
    }

    public function update(Application $application) {
    	$statement = $this->db->prepare("UPDATE applications SET version = :version WHERE application_id = :application_id");
    	$result = $statement->execute(array(':application_id' => $application->applicationId, ':version' => $application->version));
    	if (!$result) {
    	    throw new Exception("Could not update version");
    	}
    }
}