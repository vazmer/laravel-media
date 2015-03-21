<?php namespace Vazmer\Media;

use Illuminate\Database\Eloquent\Model;

class Media extends Model{

	protected $fillable = ['field_name', 'file_name', 'file_path', 'file_size', 'file_mime_type'];

	/**
	 * Get all related media files
	 *
	 * @return mixed
	 */
	public function media(){
		return $this->morphTo();
	}

}