<?php

class History extends Model
{
	public $id;
	public $device_id;
	public $date;
	public $value;
	public $state;

	public function tableName()
	{
		return "history";
	}

	public function create($device){


		if (empty($device["id"]) || !isset($device["state"])){
			return null;
		}

		$this->device_id = $device["id"];
		$this->state = $device["state"];


		if (!empty($device["value"])){
			$this->value = $device["value"];
		}

	}


	public function findHistory(Device $device){

		return $this->select(["device_id" => $device->id], $device->name);

	}
}