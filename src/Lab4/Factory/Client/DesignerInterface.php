<?php

namespace App\Lab4\Factory\Client;

interface DesignerInterface
{
    /**
     * @param resource $stream
     */
    public function createDraft($stream): PictureDraft;
}