<?php namespace Vazmer\Media;

use Vazmer\Media\File;

/**
 * Class Media
 * @package Vazmer\Media
 */
trait MediaTrait{

	/**
	 * Media items
	 */
	public function media()
	{
		return $this->morphMany('Vazmer\Media\Media', 'media');
	}


	public function getMedia($fieldName)
	{
		if(empty($this->media_fields[$fieldName]))
		{
			return null;
		}
		return $this->media()->where($this->getWhereArray($fieldName))->first();
	}

	/**
	 * Upload
	 *
	 * @return bool
	 */
	public function uploadAndSave()
	{
		if(empty($this->media_fields))
		{
			return false;
		}

		foreach($this->media_fields as $fieldName => $fieldType)
		{
			if(empty($this->media_fields[$fieldName]) || !is_object($this->getRequestFile($fieldName)))
			{
				continue;
			}

			if($fieldType == 'single')
			{
				$file = new File($this->getRequestFile($fieldName));
				if(!$file->uploadSingle()) continue;

				$this->saveSingle($file, $fieldName);
			}
		}

		return true;
	}

	protected function saveSingle(File $file, $fieldName)
	{
		$media = $this->media()->firstOrCreate($this->getWhereArray($fieldName));

		$media->file_name = $file->getFilename();
		$media->file_size = $file->getSize();
		$media->file_path = $file->getFullPath();
		$media->file_mime_type = $file->getMimeType();

		return $media->save();
	}
	

	/**
	 * Get where array
	 *
	 * @return array
	 */
	private function getWhereArray($fieldName)
	{
		return array(
			'media_id' => $this->id,
			'media_type' => get_class($this),
			'field_name' => $fieldName
		);
	}

	/**
	 * Get requested file
	 *
	 * @return array|UploadedFile
	 */
	private function getRequestFile($fieldName)
	{
		return \Request::file($fieldName);
	}



}