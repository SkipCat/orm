<?php

namespace src;

class Showing extends Entity
{
	protected $table = 'showing';
    protected $filmId;
    protected $showtime;
	
    
	public function getTable()
	{
		return $this->table;
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