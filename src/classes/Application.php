<?php

class Application {

    public $id;
    public $applicationId;
    public $secret;
    public $version;

    public function __construct(array $data) {
    	if (@$data['id']) {
    		$this->id = $data['id'];
    	}
    	
    	$this->applicationId = $data['application_id'];
    	$this->secret = $data['secret'];

    	if (@$data['version']) {
    		$this->version = $data['version'];
    	}
    	else {
    		$this->version = 1;
    	}
    }
}