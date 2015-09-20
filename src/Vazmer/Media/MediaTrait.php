<?php namespace Vazmer\Media;

use Vazmer\Media\File;

/**
 * Class Media
 * @package Vazmer\Media
 */
trait MediaTrait{

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
			$requestFiles = $this->getRequestFile($fieldName);

			if(is_object($requestFiles))
			{
				$requestFiles = [$requestFiles];
			}

			foreach($requestFiles as $rFile){
				$file = new File($rFile);

				if(!$file->uploadSingle()) continue;

				$this->saveSingle($file);
			}
		}

		return true;
	}

	protected function saveSingle(File $file)
	{
		$media = $this->media()->create();

		$media->file_name = $file->getFilename();
		$media->file_size = $file->getSize();
		$media->file_path = $file->getFullPath();
		$media->file_mime_type = $file->getMimeType();

		return $media->save();
	}


	/**
	 * Get requested file
	 *
	 * @param $fieldName
	 *
	 * @return array|UploadedFile
	 */
	private function getRequestFile($fieldName)
	{
		return \Request::file($fieldName);
	}
}