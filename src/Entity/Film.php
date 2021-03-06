<?php

namespace src\Entity;

use src\Model\EntityManager;

class Film extends EntityManager
{
	protected $table = 'film';
	protected $relatedTables = [
		'showing'
	];
	
	protected $id;
	protected $title;
	protected $producer;
	protected $releaseDate;
	protected $duration;
	protected $genre = null;
	
	
	public function getTable()
	{
		return $this->table;
	}
	
	public function getRelatedTables()
	{
		return $this->relatedTables;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function getProducer()
	{
		return $this->producer;
	}
	
	public function setProducer($producer)
	{
		$this->producer = $producer;
	}
	
	public function getReleaseDate()
	{
		return $this->releaseDate;
	}
	
	public function setReleaseDate($releaseDate)
	{
		$this->releaseDate = $releaseDate;
	}
	
	public function getDuration()
	{
		return $this->duration;
	}
	
	public function setDuration($duration)
	{
		$this->duration = $duration;
	}
	
	public function getGenre()
	{
		return $this->genre;
	}
	
	public function setGenre($genre)
	{
		$this->genre = $genre;
	}
	
	
}