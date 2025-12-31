<?php

namespace App\Enums;

enum MessageTypeEnum: string
{
    case Text = 'text';
    case File = 'file';
    case Audio = 'audio';

}
