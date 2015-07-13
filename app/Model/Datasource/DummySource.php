<?php

class DummySource extends DataSource {

	function connect() {
		$this->connected = true;

		return $this->connected;
	}

	function disconnect() {
		$this->connected = false;

		return ! $this->connected;
	}

	function isConnected() {

		return true;
	}

}