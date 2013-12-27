<?php

namespace Yearbook\Modules;

use Yearbook\Storage\MySQLAdapter;

class TimelineModel{

	protected $storage;

	public function __construct(MySQLAdapter $storage){

		$this->storage = $storage;

	}

	public function read($id){

		$query = $this->storage->readTimeline($id);

		return $query;

	}

	public function readAll($limit = 100, $offset = 0){

		$query = $this->storage->readAllTimeline($limit, $offset);

		return $query;

	}

	public function create($data){

		$query = $this->storage->createTimeline($data);

		return $query;

	}

	public function update($id, $data){

		$query = $this->storage->updateTimeline($id, $data);

		if($query > 0){
			$query = true;
		}else{
			$query = false;
		}

		return $query;

	}

	public function delete($id){

		$query = $this->storage->deleteTimeline($id);

		return $query;

	}

}