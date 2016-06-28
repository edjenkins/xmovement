<?php
namespace ResourceImage;

use App\User;

class ResourceImage
{
    public function getImage($filename, $size)
    {
		if ($filename == 'placeholder')
		{
			return '/dynamic/placeholder/' . $size;
		}
		else
		{
			return 'https://s3.amazonaws.com/xmovement/uploads/images/' . $size . '/' . $filename;
		}
    }

    public function getProfileImage($user, $size)
    {
		if ($user->avatar == 'avatar')
		{
			return '/dynamic/avatar/' . $size . '?name=' . urlencode($user->name);
		}
		else
		{
			return 'https://s3.amazonaws.com/xmovement/uploads/images/' . $size . '/' . $user->avatar;
		}
    }

    public function getFile($file)
    {
		return '/uploads/images/files/' . $file;
    }
}
