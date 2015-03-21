<?php namespace Vazmer\Media;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class File
 *
 * @package Vazmer\Media
 */
class File implements FileInterface{

	/**
	 * @var UploadedFile
	 */
	protected $file;

	/**
	 * @var string
	 */
	protected $filename = '';

	/**
	 * @var string
	 */
	protected $destinationPath = '';


	/**
	 * @param UploadedFile $file
	 */
	public function __construct(UploadedFile $file){
		$this->file = $file;
		$this->setFilename();

		//dd(\Config::get('vazmer_media.destination'));
		$this->destinationPath = 'media';
	}


	/**
	 * Upload file and move to destination path
	 *
	 * @return \Symfony\Component\HttpFoundation\File\File
	 */
	public function upload(){
		return $this->file->move($this->getDestinationPath(), $this->getFilename()); // uploading file to given path
	}

	/**
	 * Rename original filename
	 *
	 * return void
	 */
	protected function setFilename()
	{
		$originalName = $this->file->getClientOriginalName();
		$originalExt = $this->file->getClientOriginalExtension();
		// renameing image
		$this->filename = basename($originalName, '.'.$originalExt).'_'.rand(11111, 99999).'.'.$originalExt;
	}

	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * Get destination path of a file
	 *
	 * @return string
	 */
	public function getDestinationPath()
	{
		return $this->destinationPath;
	}

	public function getFullPath()
	{
		return $this->getDestinationPath().'/'.$this->getFilename();
	}


	public function getMimeType()
	{
		return $this->file->getMimeType();
	}

	public function getSize()
	{
		return $this->file->getSize();
	}

	/**
	 * Get uploaded file
	 *
	 * @return array|UploadedFile
	 */
	public function getUploadedFile()
	{
		return $this->file;
	}

	public function uploadSingle()
	{
		if (!isset($this->file))
		{
			return false;
		}

		$this->file = $this->upload();

		return true;
	}
}