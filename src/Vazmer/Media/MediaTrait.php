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
		if(!in_array($fieldName, $this->media_fields))
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

		foreach($this->media_fields as $fieldName)
		{
			if(empty($this->media_fields) || !in_array($fieldName, $this->media_fields))
			{
				continue;
			}

			$requestFiles = $this->getRequestFile($fieldName);

			if(is_object($requestFiles))
			{
				$requestFiles = [$requestFiles];
			}

			foreach($requestFiles as $rFile){
				$file = new File($rFile);

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