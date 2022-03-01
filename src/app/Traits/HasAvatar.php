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
        if (!$this->avatar || $this->avatar == '') return null;
        return pathinfo($this->avatar, PATHINFO_EXTENSION);;
    }

    public function getAvatarDirnameAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        $dirname = pathinfo($this->avatar, PATHINFO_DIRNAME);
        return $dirname != '.' ? $dirname : '';
    }

    public function getAvatarFilenameAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        if (!$this->avatar || $this->avatar == '') return null;
        return pathinfo($this->avatar, PATHINFO_FILENAME);
    }

    public function getAvatarFilepathAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        $dir = $this->avatar_dirname != '' ? $this->avatar_dirname . "/" : '';
        return "{$dir}{$this->avatar_filename}.{$this->avatar_extension}";
    }

    protected function getAvatarFilepathThumbAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        $size = self::$size_thumb;
        $dir = $this->avatar_dirname != '' ? $this->avatar_dirname . "/" : '';
        return "{$dir}{$this->avatar_filename}-{$size}w.{$this->avatar_extension}";
    }

    public function getAvatarThumbUrlAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        return Storage::disk('s3')->url($this->avatar_filepath_thumb);
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar || $this->avatar == '') return null;
        return Storage::disk('s3')->url($this->avatar_filepath);
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
        $s3->put($this->avatar_filepath, $imageFile, 'public');
        $s3->put($this->avatar_filepath_thumb, $imageFileThumb, 'public');
    }

    function is_url($uri)
    {
        if (preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri)) {
            return $uri;
        } else {
            return false;
        }
    }
}
