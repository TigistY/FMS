<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;


class Permission extends SpatiePermission
{
  
    protected $fillable = ['name', 'guard_name', 'display_name', 'group'];

    
}
//BelongToMany(many to many)-->role to permission,then one role many permission and one permission many role,using pivot table