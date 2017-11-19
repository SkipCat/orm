<?php

namespace src\Entity;

use src\Model\EntityManager;

class Showing extends EntityManager
{
	protected $table = 'showing';
	
	protected $id;
    protected $filmId;
    protected $showtime;
	
    
	public function getTable()
	{
		return $this->table;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getFilmId()
	{
		return $this->filmId;
	}
	
	public function setFilmId($filmId)
	{
		$this->filmId = $filmId;
	}
	
	public function getShowtime()
	{
		return $this->showtime;
	}
	
	public function setShowtime($showtime)
	{
		$this->showtime = $showtime;
	}
	
}