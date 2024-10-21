<?php

namespace app\Interfaces;

interface FileUploaderInterface
{
    public function upload($file, $destinationFolder): string;
}