<?php

namespace Storage;

use PDO;
use PDOException;

class MySQLAdapter{

	protected $db;

	public function __construct(PDO $db){

		$this->db = $db;

	}

	public function readTimeline($id){

		$query = "SELECT * FROM timeline WHERE id = :id";
		$sth = $this->db->prepare($query);
		$sth->bindValue('id', $id);

		try{

			$sth->execute();
			$row = $sth->fetch(PDO::FETCH_OBJ);
			return $row;

		}catch(PDOException $db_err){

			throw $db_err;

		}

	}

	public function readAllTimeline($limit, $offset){

		$query = "SELECT * FROM timeline";
		if(is_int($offset) AND is_int($limit)){
			$query .= " LIMIT :offset, :limit";
		}elseif(is_int($limit)){
			$query .= " LIMIT :limit";
		}

		$sth = $this->db->prepare($query);
		$sth->bindValue('limit', $limit);
		$sth->bindValue('offset', $offset);

		try{

			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_OBJ);
			return $result;

		}catch(PDOException $db_err){

			throw $db_err;

		}

	}

	public function createTimeline($data){

		$query = "INSERT timeline (date, title, description, photo) VALUES (:date, :title, :description, :photo)";
		$sth = $this->db->prepare($query);
		$sth->bindValue('date', date('Y-m-d H:i:s'), PDO::PARAM_STR);
		$sth->bindValue('title', $data['title'], PDO::PARAM_STR);
		$sth->bindValue('description', $data['description'], PDO::PARAM_STR);
		$sth->bindValue('photo', $data['photo'], PDO::PARAM_STR);

		try{

			$sth->execute();
			return $this->db->lastInsertId();

		}catch(PDOException $db_err){

			throw $db_err;

		}

	}

	public function updateTimeline($id, $data){

		$update_placeholder = implode(' = ?, ', array_keys($data))  . ' = ?';
		$query = "UPDATE timeline SET $update_placeholder WHERE id = ?";
		$sth = $this->db->prepare($query);
		$data[] = $id;

		try{
		
			//execute like an array!
			$sth->execute(array_values($data));
			return $sth->rowCount();
		
		}catch(PDOException $db_err){

			throw $db_err;
		
		}

	}

	public function deleteTimeline($id){

		$query = "DELETE timeline WHERE id = :id";
		$sth = $this->db->prepare($query);
		$sth->bindValue('id', $id);

		try{

			$sth->execute();
			return $sth->rowCount();
		
		}catch(PDOException $db_err){

			throw $db_err;

		}

	}

}