<?php

namespace Vazmer\Media;

use Illuminate\Database\Eloquent\Model;

use Vazmer\Media\MediaTrait;

/**
 * Vazmer\Media\Media
 */
class Media extends Model
{
	use MediaTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'media';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['file_name', 'file_path', 'file_size', 'file_mime_type'];

	/**
	 * Media fields
	 *
	 * @var array
	 */
	protected $media_fields = ['file'];
}
