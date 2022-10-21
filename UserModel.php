<?php

namespace assaad\core;

use assaad\core\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName() : string;
}