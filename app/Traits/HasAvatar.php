<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageProcess;
use function Stringy\create as s;

trait HasAvatar
{

    public static $size_thumb = 150;

    public function getAvatarExtensionAttribute()
    {
        return pathinfo($this->avatar, PATHINFO_EXTENSION);;
    }

    public function getAvatarDirnameAttribute()
    {
        $dirname = pathinfo($this->avatar, PATHINFO_DIRNAME);
        return $dirname != '.' ? $dirname : '';
    }

    public function getAvatarFilenameAttribute()
    {
        return pathinfo($this->avatar, PATHINFO_FILENAME);
    }

    public function getAvatarFilepathAttribute()
    {
        return "{$this->avatar_dirname}/{$this->avatar_filename}.{$this->avatar_extension}";
    }

    protected function getAvatarFilepathThumbAttribute()
    {
        $size = self::$size_thumb;
        $dir = $this->avatar_dirname != '' ? $this->avatar_dirnam . "/" : '';
        return "{$dir}{$this->avatar_filename}-{$size}w.{$this->avatar_extension}";
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::disk('s3')->url($this->avatar_filepath);
    }

    public function getAvatarThumbUrlAttribute()
    {
        return Storage::disk('s3')->url($this->avatar_filepath_thumb);
    }

    public function addAvatar($image)
    {
        $this->avatar = 'avatars/' . $image->hashName();
        $this->avatar_pretty = 'avatars/' . $image->getClientOriginalName();
        $this->_generate($image);
        $this->save();
    }

    function _generate($image)
    {
        $imageFile = ImageProcess::make($image)->stream()->__toString();
        $imageFileThumb = ImageProcess::make($image)->fit(self::$size_thumb)->stream()->__toString();
        $s3 = Storage::disk('s3');
        $s3->put('avatars/' . $this->avatar_filepath, $imageFile, 'public');
        $s3->put('avatars/' . $this->avatar_filepath_thumb, $imageFileThumb, 'public');
    }
}
